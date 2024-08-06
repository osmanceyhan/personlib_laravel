<?php

namespace App\Http\Controllers\Auth;

use App\Enumerations\BasicEnum;
use App\Enumerations\UsersEnum;
use App\Http\Controllers\Controller;
use App\Mail\RegisterMail;
use App\Mail\ResetPasswordMail;
use App\Models\Company\Companies;
use App\Models\PasswordResets;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function loginCheck($request)
    {
        $validate = [
            'auth_email' => 'required|email|exists:users,email',
            'password' => 'required',
        ];

        // Validate all error back
        $validator = Validator::make($request->all(),$validate);
        if($validator->fails()){
            return [
                    'status' => 'danger',
                    'title' => 'E-Posta ve şifrenizi kontrol edin.',
                    'message' => $validator->errors()->first()
                ];
        }
        try{

            $check = User::where('email',$request->auth_email)->first();
            switch ($check->status) {
                case UsersEnum::PASSIVE->value:
                    return [
                        'status' => 'danger',
                        'title' => 'Hesabınız askıya alınmıştır.',
                        'message' => 'Lütfen yöneticinizle iletişime geçin.'
                    ];
                break;
                case UsersEnum::CANCELLED->value:
                    return [
                        'status' => 'danger',
                        'title' => 'Hesabınız iptal edilmiştir.',
                        'message' => 'Lütfen yöneticinizle iletişime geçin.'
                    ];
                break;
                case UsersEnum::BANNED->value:
                    return [
                        'status' => 'danger',
                        'title' => 'Hesabınız yasaklanmıştır.',
                        'message' => 'Lütfen yöneticinizle iletişime geçin.'
                    ];
                break;
                case UsersEnum::DEMO->value:
                    // 15 gun kontrolu
                    $checkDate = now()->diffInDays($check->created_at);
                    if($checkDate > 15){
                        return [
                            'status' => 'danger',
                            'title' => 'Demo süreniz doldu.',
                            'message' => 'Lütfen yöneticinizle iletişime geçin.'
                        ];
                    }
                break;
            }

            if($check){
                // Şifreyi kontrol et
                $checkPass = Hash::check($request->password,$check->password);
                if($checkPass) {
                    // Auth attedmpt
                    $auth = Auth::attempt(['email' => $check->email, 'password' => $request->password]);

                    return [
                        'status' => 'success',
                        'title' => 'Başarılı',
                        'message' => 'Giriş başarılı.'
                    ];
                }else{
                    return [
                        'status' => 'danger',
                        'title' => 'Hatalı şifre',
                        'message' => 'Şifrenizi kontrol edin.'
                    ];
                }
            }

        }catch (\Exception $e){
            return [
                    'status' => 'danger',
                    'title' => 'Hata',
                    'message' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
                ];
        }
    }

    public function login(Request $request){
        $login = $this->loginCheck($request);
        if($login['status'] == 'danger'){
            return redirect()->back()
                ->withInput()
                ->with('alert',$login);
        }
        return redirect()->route('index')->with('alert',$login);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function register(Request $request){
        // Validation name,surname,email,phone,company_name,company_title,employees_count,kvkk
        $validate = [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'company_name' => 'required',
            'company_title' => 'required',
            'employees_count' => 'required',
            'kvkk' => 'required',
        ];

        // Validate all error back
        $validator = Validator::make($request->all(),$validate);
        if($validator->fails()){
            return redirect()->back()->with('modalAlert',
                [
                    'status' => 'danger',
                    'title' => 'Alanları eksiksiz doldurun',
                    'message' => $validator->errors()->first()
                ])->withInput();
        }
        try{
            // Create User
            $data = $request->all();
            // Random 10-12 length a-z0-9
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'),0,12);
            $data['password'] = Hash::make($password);
            $data['status'] = UsersEnum::DEMO->value;
            $user = User::create($data);
            // Company
            $companyData = [
                "owner_id" => $user->id,
                "name" => $request->company_name,
                "title" => $request->company_title,
                "status" => BasicEnum::ACTIVE->value,
            ];

            $company = Companies::create($companyData);

            // User Update
            User::where('id',$user->id)->update(['company_id' => $company->id]);

            $mailData = [
                'user' => $user,
                'password' => $password,
            ];


            $mailSend = Mail::to($user->email)->send(new RegisterMail($mailData));

            return redirect()->back()->with('alert',
                [
                    'status' => 'success',
                    'title' => 'Başarılı',
                    'message' => 'Kayıt işlemi başarılı. Şifreniz mail adresinize gönderilmiştir.'
                ])->withInput();
        }catch (QueryException $e){
            // with input old()
            return redirect()->back()->with('modalAlert',
                [
                    'status' => 'danger',
                    'title' => 'Hata',
                    'message' => 'Bu mail adresi zaten kayıtlı.'
                ])->withInput();
        } catch (\Exception $e){
            return redirect()->back()->with('modalAlert',
                [
                    'status' => 'danger',
                    'title' => 'Hata',
                    'message' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
                ])->withInput();
        }

    }

    public function forgetPasswordReset(Request $request){
        $validate = [
            'new_password' => 'required|min:6',
            'new_password_again' => 'required|same:new_password',
            'token' => 'required'
        ];
        // Validate all error back
        $validator = Validator::make($request->all(),$validate);
        if($validator->fails()){
            return redirect()->back()
                ->with('forgetPasswordError',true)
                ->withInput()
                ->with('alert',[
                'status' => 'danger',
                'title' => 'Lütfen alanları kontrol edin.',
                'message' => $validator->errors()->first()
            ]);
        }
        $newPassword = Hash::make($request->new_password);
        try {
            $passwordReset = PasswordResets::where('token', $request->token)->first();
            if ($passwordReset) {
                $user = User::where('email', $passwordReset->email)->first();
                $user->password = $newPassword;
                $user->save();
                $passwordReset->delete();
                $auth = Auth::attempt(['email' => $passwordReset->email, 'password' => $request->new_password]);

                return redirect()->route('index')->withInput()
                ->with('forgetPassword',true)
                ->with('alert',[
                    'status' => 'success',
                    'title' => 'Başarılı',
                    'message' => 'Şifreniz başarıyla değiştirildi.'
                ]);
            }
            return redirect()->back()->withInput()
            ->with('forgetPasswordError',true)
            ->with('alert',[
                'status' => 'danger',
                'title' => 'Hata',
                'message' => 'Sıfırlama kodu geçersiz. Lütfen tekrar deneyin.'
            ]);

        }catch (\Exception $e){
            return redirect()->back()->withInput()
                ->with('forgetPasswordError',true)
                ->with('alert',[
                    'status' => 'danger',
                    'title' => 'Hata',
                    'message' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
                ]);
        }
    }

    public function forgetPasswordProcess(Request $request)
    {
        $validate = [
            'auth_email' => 'required|email|exists:users,email',
        ];

        // Validate all error back
        $validator = Validator::make($request->all(),$validate);
        if($validator->fails()){
            return [
                    'status' => 'danger',
                    'title' => 'Lütfen e-posta adresinizi kontrol edin.',
                    'message' => $validator->errors()->first()
                ];
        }

        try{

            // 10 dakika içinde birden fazla sıfırlama kodu gönderilmesini kontrol et
            $passwordReset = PasswordResets::where('email', $request->auth_email)
                ->where('created_at', '>', now()->subMinutes(10))
                ->first();

            if ($passwordReset) {
                return [
                    'status' => 'danger',
                    'title' => 'Hata',
                    'message' => '10 dakika içerisinde sadece 1 sıfırlama kodu alabilirsiniz.'
                ];
            }

            $exist = User::where('email',$request->auth_email)->first();


            // Create or update
            // Token Create Forget no substr
            $token = Str::random(40);

            $passwordReset = PasswordResets::updateOrCreate(
                ['email' => $request->auth_email],
                [
                    'email' => $request->auth_email,
                    'token' => $token
                ]
            );

            // Mail verilerini hazırla ve gönder
            $mailData = [
                'user' => $exist,
                'token' => $token,
            ];
            $mailSend = Mail::to($exist->email)->send(new ResetPasswordMail($mailData));

            return [
                    'status' => 'success',
                    'title' => 'Başarılı',
                    'message' => 'Sıfırlama kodu mail adresinize gönderilmiştir.'
                ];
        }catch (\Exception $e){
            return [
                    'status' => 'danger',
                    'title' => 'Hata',
                    'message' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
                ];
        }
    }

    public function forgetPassword(Request $request)
    {
        $forgetProcess = $this->forgetPasswordProcess($request);
        if($forgetProcess['status'] == 'success'){
            return redirect()->back()
                ->withInput()
                ->with('forgetPassword',true)
                ->with('alert',$forgetProcess);
        }
        return redirect()->back()
            ->with('forgetPasswordError',false)
            ->withInput()
            ->with('alert',$forgetProcess);
    }

    public function showLoginForm(){
        return view('auth.login');
    }
}

<?php
namespace App\Services\Auth;

use App\Enumerations\BasicEnum;
use App\Enumerations\UsersEnum;
use App\Enumerations\UserTypeEnum;
use App\Mail\ForgetPasswordMail;
use App\Mail\MemberPasswordUpdated;
use App\Mail\MemberVerificationMail;
use App\Models\Admins;
use App\Models\GeoCodes;
use App\Models\PasswordResets;
use App\Services\EloquentServices\EloquentService;
use App\Services\UploadService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class AuthService
{

    private UploadService $uploadService;

    public function __construct(){
        $this->model  = new User();
        $this->cache = Cache::remember('users', now()->addWeek(1),
            function ()  {
                return $this->model->all();
            });

        $this->uploadService = new UploadService();
    }

    /**
     * @param $email
     * @return array
     */
    public function forgotPassword($email){
        $userCheck = User::where('email', $email)->first();


        // Son şifre sıfırlama isteğini kontrol et
        $lastRequest = PasswordResets::where('email', $email)->latest()->first();
        if ($lastRequest && Carbon::parse($lastRequest->created_at)->addMinutes(5) > Carbon::now()) {
            return [
                'data' => [],
                'status' => 429, // Çok fazla istek hatası
                'message' => __('api.too_many_requests')
            ];
        }

        // Token oluştur ve tabloya kaydet
        $token = Str::random(60);
        PasswordResets::updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Mail Send Process
        $forgotLink =  config('app.url').'/reset-password/'.$token.'/'.$userCheck->email;
        $mailData = [
            'users' => $userCheck,
            'token' => $token,
            'forgot_link' => $forgotLink,
        ];

        Mail::to($userCheck->email)->send(new ForgetPasswordMail($mailData));


        return [
            'data' => ['token' => $token],
            'status' => 200,
            'message' => __('api.success')
        ];
    }

    /**
     * @param $token
     * @return array
     */
    public function verifyToken($token,$email){
        $tokenCheck = PasswordResets::where('token', $token)->where('email',$email)->first();
        if (!$tokenCheck) {
            return [
                'data' => [],
                'status' => 400,
                'message' => __('api.token_invalid')
            ];
        }

        return [
            'data' => ['email' => $tokenCheck->email],
            'status' => 200,
            'message' => __('api.token_valid')
        ];
    }

    public function verifyEmail($email,$verifyToken) {
            $user = User::where('email', $email)->where('verify_token', $verifyToken)->first();

            if (!$user) {
                return [
                    'data' => [],
                    'status' => 400,
                    'message' => __('api.verify_token_invalid')
                ];
            }

            // Email doğrulamasını gerçekleştirme
            $user->email_verified_at = now();
            $user->status = UsersEnum::ACTIVE->value;
            $user->save();
            return [
                'data' => $user,
                'status' => 200,
                'message' => __('api.email_verified')
            ];

    }

    public function verifyEmailSend($email) {
        $user = User::where('email', $email)
            ->whereNull('email_verified_at')
            ->first();

        if (!$user) {
            return [
                'data' => [],
                'status' => 400,
                'message' => __('api.verify_token_invalid')
            ];
        }
        Mail::to($user->email)->send(new MemberVerificationMail($user));

        return [
            'data' => $user,
            'status' => 200,
            'message' => __('api.email_verified')
        ];

    }


    public function register($request){

        $request = (object) $request;
        $verifyToken =  Str::random(60);
        $dualCode = GeoCodes::where('code',$request->dual_code)->first();
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'country_id' => $request->country_id,
            'dual_code' => $dualCode->geo_code,
            'verify_token' =>$verifyToken,
            'phone' => $request->phone,
        ]);

        $token = $user->createToken('MyApp')->accessToken;
        $user->token = $token->token;

        $user->verify_link = config('app.url').'/email-verify/'.$verifyToken.'/'.$user->email; //TODO : Verify link verilecek clientdan.

        // Mail send

        Mail::to($user->email)->send(new MemberVerificationMail($user));

        return [
            'data' => $user,
            'status' => 200,
            'message' => __('api.success')
        ];
    }

    /**
     * @param $token
     * @param $newPassword
     * @return array
     */
    public function resetPassword($token, $newPassword){
        $tokenCheck = PasswordResets::where('token', $token)->first();
        if (!$tokenCheck) {
            return [
                'data' => [],
                'status' => 400,
                'message' => __('api.token_invalid')
            ];
        }

        $user = User::where('email', $tokenCheck->email)->first();
        if (!$user) {
            return [
                'data' => [],
                'status' => 400,
                'message' => __('api.user_not_found')
            ];
        }

        // Kullanıcının şifresini güncelle
        $user->password = Hash::make($newPassword);
        $user->save();

        // Şifre sıfırlama talebini sil
        PasswordResets::where('token', $token)->delete();

        return [
            'data' => $user,
            'status' => 200,
            'message' => __('api.password_reset_success')
        ];
    }


    public function cacheClear(){
        Cache::forget('users');
        $this->cache = Cache::remember('users', now()->addWeek(1),
            function ()  {
                return $this->model->all();
            });
    }


}

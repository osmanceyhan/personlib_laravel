<?php

namespace App\Http\Controllers\Managers;

use App\Enumerations\ApprovalEnum;
use App\Enumerations\BasicEnum;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequests;
use App\Models\PaymentRequests;
use App\Models\User;
use App\Models\UserInfos;
use App\Services\UploadService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{


    public function __construct()
    {
        $this->model = new User();
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function employees(){
        try{
            $user = User::where('id',Auth::id())->first();
            $userInfo = $user->getUserInfo;

            // Yıllık izin hesaplama
            $available_leave = $userInfo->calculateAnnualLeaveDays();
            $employees = User::where('company_id',$user->company_id)
                ->get();

            return view('employees.index',compact('user','userInfo','employees'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'İşlem başarısız!']);
        }
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function requests(){
        try{
            $user = User::where('id',Auth::id())->first();
            $company = $user->getCompany;
            $leaveRequests = LeaveRequests::where('company_id',$company->id)->get();
            $userInfo = $user->getUserInfo;
            $companyId = $user->company_id;
            $paymentInfo = [
                'count' => PaymentRequests::where('company_id',$companyId)->count(),
                'overtime' => PaymentRequests::where('company_id',$companyId)
                    ->where('payment_type','OVERTIME')
                    ->orderBy('created_at','desc')->get(),
                'expenditure' => PaymentRequests::where('company_id',$companyId)
                    ->where('payment_type','EXPENDITURE')
                    ->orderBy('created_at','desc')->get(),
                'advance_payments' => PaymentRequests::where('company_id',$companyId)
                    ->where('payment_type','ADVANCE_PAYMENT')
                    ->orderBy('created_at','desc')->get()
            ];
            if($user->user_role == "EMPLOYEE"){
                $paymentInfo = [
                    'count' => PaymentRequests::where('user_id',$user->id)->count(),
                    'overtime' => PaymentRequests::where('user_id',$user->id)
                        ->where('payment_type','OVERTIME')
                        ->orderBy('created_at','desc')->get(),
                    'expenditure' => PaymentRequests::where('user_id',$user->id)
                        ->where('payment_type','EXPENDITURE')
                        ->orderBy('created_at','desc')->get(),
                    'advance_payments' => PaymentRequests::where('user_id',$user->id)
                        ->where('payment_type','ADVANCE_PAYMENT')
                        ->orderBy('created_at','desc')->get()
                ];
                $leaveRequests = LeaveRequests::where('user_id',$user->id)->get();
            }


            $datas = [
                "leave_requests"  => $leaveRequests,
                "payment_info" => $paymentInfo,
            ];

            return view('requests.index',compact('user','userInfo','datas'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'İşlem başarısız!']);
        }
    }


    public function employees_create(Request $request)
    {
        try{
            $user = User::where('id',Auth::id())->first();
            if($user->user_role == "EMPLOYEE"){
                return redirect()->back()->with('alert',['status' => 'danger','title' => 'Yetki Geçersiz','message' => 'Yetki Geçersiz!']);
            }
            $userRoles = [
                'MANAGER' => 'Yönetici',
                'EMPLOYEE' => 'Çalışan'
            ];
            $company = $user->getCompany;
            return view('employees.create',compact('company','user','userRoles'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'İşlem başarısız!']);
        }

    }

    public function employees_edit(Request $request,$id)
    {
        try{
            $user = User::where('id',$id)->first();
            $userInfo = UserInfos::where('user_id',$id)->first();
            $loginUser = User::where('id',Auth::id())->first();
            if($loginUser->user_role == "EMPLOYEE"){
                return redirect()->back()->with('alert',['status' => 'danger','title' => 'Yetki Geçersiz','message' => 'Yetki Geçersiz!']);
            }

            $userRoles = [
                'MANAGER' => 'Yönetici',
                'EMPLOYEE' => 'Çalışan'
            ];
            $company = $user->getCompany;
            return view('employees.edit',compact('id','company','user','userInfo','userRoles'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'İşlem başarısız!']);
        }

    }

    public function employees_store(Request $request)
    {


        // Validate required fields
        $validate = [
            'user_role' => 'required',
            'gender' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'birthdate' => 'required',
            'password' => 'required',
            'educational_status' => 'required',
            'education_complete_status' => 'required',
            'marital_status' => 'required',
            'children_count' => 'required',
            'country' => 'required',
            'avatar' => 'required',
            'contract_type' => 'required',
            'work_type' => 'required',
            'start_date' => 'required',
        ];

        // Error with alert back
        // Validate all error back
        $validator = Validator::make($request->all(),$validate);
        if($validator->fails()){
            return redirect()->back()->with('alert',
                [
                    'status' => 'danger',
                    'title' => 'Alanları eksiksiz doldurun',
                    'message' => $validator->errors()->first()
                ])->withInput();
        }

        try{
            // User olustur
            $uploadService = new UploadService();

            $user = User::where('id',Auth::id())->first();

            if($user->user_role == "EMPLOYEE"){
                return redirect()->back()->with('alert',['status' => 'danger','title' => 'Yetki Geçersiz','message' => 'Yetki Geçersiz!']);
            }
            $company  = $user->getCompany;
            $userData = requestFilter($request->all());
            $userData['password'] =  Hash::make($userData['password']);
            $userData['company_id'] = $company->id;
            $userData['status'] = BasicEnum::ACTIVE->value;

            // Create user
            if ($request->hasFile('avatar')) {
                $fileName = $uploadService
                    ->setModule('avatar')
                    ->upload($request->file('avatar'));
                $data['avatar'] = $fileName;
            }

            $newUser = User::create($userData);

            // Create User Info
            $userInfoData = requestFilter($request->all());
            $userInfoData['user_id'] = $newUser->id;
            $userInfoData['company_id'] = $company->id;
            $newUserInfo = UserInfos::create($userInfoData);

            // Success
            return redirect()->route('employees.index')->with('alert',
                [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kullanıcı oluşturuldu'
                ]);

        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'İşlem başarısız!']);
        }

    }

    public function employees_update(Request $request,$id)
    {
        // Validate required fields
        $validate = [
            'user_role' => 'required',
            'gender' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'birthdate' => 'required',
            'educational_status' => 'required',
            'education_complete_status' => 'required',
            'marital_status' => 'required',
            'children_count' => 'required',
            'country' => 'required',
            'contract_type' => 'required',
            'work_type' => 'required',
            'start_date' => 'required',
        ];

        // Error with alert back
        // Validate all error back
        $validator = Validator::make($request->all(),$validate);
        if($validator->fails()){
            return redirect()->back()->with('alert',
                [
                    'status' => 'danger',
                    'title' => 'Alanları eksiksiz doldurun',
                    'message' => $validator->errors()->first()
                ])->withInput();
        }

        try{
            $uploadService = new UploadService();
            // User Update
            $loginUser = User::where('id',$id)->first();
            if($loginUser->user_role == "EMPLOYEE"){
                return redirect()->back()->with('alert',['status' => 'danger','title' => 'Yetki Geçersiz','message' => 'Yetki Geçersiz!']);
            }
            $company  = $loginUser->getCompany;
            $requestData = $request->all();
            $userData = [
                "user_role" => $requestData['user_role'],
                'name' => $requestData['name'],
                'surname' => $requestData['surname'],
                "email" => $requestData['email'],
                "gender" => $requestData['gender'],
                "phone" => $requestData['phone'],
            ];
            if($requestData['password']){
                $userData['password'] = Hash::make($requestData['password']);
            }
            if ($request->hasFile('avatar')) {
                $fileName = $uploadService
                    ->setModule('avatar')
                    ->upload($request->file('avatar'));
                $userData['avatar'] = $fileName;
            }
            $userData['company_id'] = $company->id;
            $userData['status'] = BasicEnum::ACTIVE->value;

            // Update user

            $newUser = User::where('id',$id)->update($userData);

            // Update User Info
            $userInfoData = [
                'company_id' => $company->id,
                'title' => $requestData['title'],
                'start_date' => $requestData['start_date'],
                'contract_type' => $requestData['contract_type'],
                'end_date' => @$requestData['end_date'],
                'work_type' => $requestData['work_type'],
                'birthdate' => $requestData['birthdate'],
                'tc_number' => $requestData['tc_number'],
                'military_status' => $requestData['military_status'],
                'military_done_date' => $requestData['military_done_date'],
                'military_postponement_date' => $requestData['military_postponement_date'],
                'educational_status' => $requestData['educational_status'],
                'education_complete_status' => $requestData['education_complete_status'],
                'marital_status' => $requestData['marital_status'],
                'children_count' => $requestData['children_count'],
                'adress' => $requestData['adress'],
                'adress_two' => $requestData['adress_two'],
                'city' => $requestData['city'],
                'country' => $requestData['country'],
                'zip_code' => $requestData['zip_code'],
                'address_phone' => $requestData['address_phone'],
                'bank_name' => $requestData['bank_name'],
                'bank_type' => $requestData['bank_type'],
                'bank_iban' => $requestData['bank_iban'],
                'bank_number' => $requestData['bank_number'],
                'emergency_fullname' => $requestData['emergency_fullname'],
                'emergency_phone' => $requestData['emergency_phone'],
                'emergency_proximity_degree' => $requestData['emergency_proximity_degree'],
            ];


            $newUserInfo = UserInfos::where('user_id',$id)->update($userInfoData);

            // Success
            return redirect()->route('employees.index')->with('alert',
                [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kullanıcı başarıyla güncellendi'
                ]);

        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'İşlem başarısız!']);
        }

    }



    /**
     * @param $
     * @return JsonResponse
     */
    public function payment_requests(){
        try{
            $user = User::where('id',Auth::id())->first();
            $userInfo = $user->getUserInfo;

            $paymentInfo = [
                'count' => PaymentRequests::where('user_id',Auth::id())->count(),
                'overtime' => PaymentRequests::where('user_id',Auth::id())
                    ->where('payment_type','OVERTIME')
                    ->orderBy('created_at','desc')->get(),
                'expenditure' => PaymentRequests::where('user_id',Auth::id())
                    ->where('payment_type','EXPENDITURE')
                    ->orderBy('created_at','desc')->get(),
                'advance_payments' => PaymentRequests::where('user_id',Auth::id())
                    ->where('payment_type','ADVANCE_PAYMENT')
                    ->orderBy('created_at','desc')->get()
            ];

            return view('accounts.payments',compact('user','userInfo','paymentInfo'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'İşlem başarısız!']);
        }
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function edit($id){
        try{
            $item = $this->model->find($id);
            return view('definations.leave_types.edit',compact('item'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Düzenlenemedi!']);
        }
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function show(){
        try{
            $user = User::where('id',Auth::id())->first();

            $companyId = $user->company_id;

            $item = $this->model->find($companyId);
            return view('company.index',compact('item'));
        }catch (\Exception $e){
            dd($e);
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }

    /**
     * @param $
     * @return JsonResponse
     */
    public function create(){
        try{
            return view('definations.leave_types.create');
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }

    /**
     * @param $
     * @return JsonResponse
     */
    public function store(Request $request){
            try{
                // Store
                $data = requestFilter($request->all());
                $process = $this->model->create($data);
                return redirect()->route('leave_types.index')->with('alert',['status' => 'success','title' => 'İşlem Başarılı','message' => 'Veri Oluşturuldu!']);
            }catch (QueryException $e){
                return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Oluşturulamadı!']);
            }catch (\Exception $e){

                return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Oluşturulamadı!']);
            }

    }

    /**
     * @param $
     * @return JsonResponse
     */
    public function update(Request $request){
        try{
            $user = User::where('id',Auth::id())->first();
            $companyId = $user->company_id;

            $uploadService = new UploadService();
            $data = requestFilter($request->all());
            if ($request->hasFile('logo')) {
                $fileName = $uploadService
                    ->setModule('companies')
                    ->upload($request->file('logo'));
                $data['logo'] = $fileName;
            }
            $item = $this->model->find($companyId)->update($data);
            return redirect()->back()->with('alert',['status' => 'success','title' => 'İşlem Başarılı','message' => 'Veri Güncellendi!']);
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Güncellenemedi!']);
        }
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function destroy($id){
        try{
            // Statu degistirir
            $get = $this->model->whereId($id)->first();
            $status = $get->status == BasicEnum::ACTIVE->value ?
                BasicEnum::PASSIVE->value : BasicEnum::ACTIVE->value;
            $return = $this->model->whereId($id)->update(['status' => $status]);
            return redirect()->route('geoCodes.index');
        }catch (\Exception $e){
             return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }

}

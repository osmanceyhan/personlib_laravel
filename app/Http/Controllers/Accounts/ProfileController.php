<?php

namespace App\Http\Controllers\Accounts;

use App\Enumerations\ApprovalEnum;
use App\Enumerations\BasicEnum;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequests;
use App\Models\PaymentRequests;
use App\Models\User;
use App\Services\UploadService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{


    public function __construct()
    {
        $this->model = new User();
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function index(){
        try{
            $user = User::where('id',Auth::id())->first();
            $userInfo = $user->getUserInfo;

            return view('accounts.profile',compact('user','userInfo'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'İşlem başarısız!']);
        }
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function information(){
        try{
            $user = User::where('id',Auth::id())->first();
            $userInfo = $user->getUserInfo;

            return view('accounts.information',compact('user','userInfo'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'İşlem başarısız!']);
        }
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function leave_requests(){
        try{
            $user = User::where('id',Auth::id())->first();
            $userInfo = $user->getUserInfo;

            // Yıllık izin hesaplama
            $available_leave = $userInfo->calculateAnnualLeaveDays();
            $leaveInfo = [
                'count' => LeaveRequests::where('user_id',Auth::id())->count(),
                'used_day' => LeaveRequests::where('user_id',Auth::id())->where('status',ApprovalEnum::APPROVED->value)->sum('total'),
                'rejected_day' => LeaveRequests::where('user_id',Auth::id())->where('status',ApprovalEnum::REJECTED->value)->sum('total'),
                'waiting_day' => LeaveRequests::where('user_id',Auth::id())->where('status',ApprovalEnum::WAITING->value)->sum('total'),
                'available_leave' => $available_leave,
                'leave_requests' => LeaveRequests::where('user_id',Auth::id())->orderBy('created_at','desc')->get()
            ];

            return view('accounts.leave_request',compact('user','userInfo','leaveInfo'));
        }catch (\Exception $e){
            dd($e);
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
            dd($e);
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
                dd($e);
                return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Oluşturulamadı!']);
            }catch (\Exception $e){
                dd($e);

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
            dd($e);
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

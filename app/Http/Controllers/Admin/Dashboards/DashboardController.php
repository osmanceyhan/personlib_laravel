<?php

namespace App\Http\Controllers\Admin\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequests;
use App\Models\PaymentRequests;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    //

    public function index()
    {



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

        return view('dashboard.index',compact('leaveRequests','datas','user','userInfo'));
    }

}

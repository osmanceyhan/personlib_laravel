<?php

namespace App\Http\Controllers;

use App\Enumerations\ApprovalEnum;
use App\Enumerations\BasicEnum;
use App\Http\Controllers\Controller;
use App\Models\Company\Companies;
use App\Models\LeaveTypes;
use App\Models\PaymentRequests;
use App\Models\User;
use App\Services\UploadService;
use Carbon\CarbonPeriod;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserRequestController extends Controller
{
    //

    public function __construct()
    {
        $this->model = new PaymentRequests();
    }

    public function store(Request $request)
    {
       try{
           $user = User::where('id',Auth::id())->first();
           $companyId = $user->company_id;
           $additionalData = [
               "amount",
                "used_date",
                "tax_rate",
                "receipt_date",
                "start_date",
                "start_time",
                "hour",
                "minute",
           ];
           $requestData = [
               "company_id" =>$companyId,
               'user_id' => Auth::id(),
               'payment_type' => $request->payment_type,
               'comment' => $request->comment,
               'status' => ApprovalEnum::WAITING->value,
               'payment_status' => ApprovalEnum::WAITING->value,
           ];
            $requestAll = $request->all();
            foreach ($additionalData as $data){
                if(isset($requestAll[$data])){
                 $requestData[$data] = $requestAll[$data];
                }
            }

           $uploadService = new UploadService();
           if($request->attachment){
               if ($request->hasFile('attachment')) {
                   $fileName = $uploadService
                       ->setModule('attachment')
                       ->upload($request->file('attachment'));
                   $requestData['attachment'] = $fileName;
               }
           }
           $create = PaymentRequests::create($requestData);
           if(!$create){
               return response()->json([
                   'success' => false,
                   'message' => 'Ödeme talebi oluşturulurken bir hata oluştu.'
               ]);
           }

           return response()->json([
               'success' => true,
                'message' => 'Ödeme talebi başarıyla oluşturuldu.'
           ]);
       }catch (QueryException $e){
           return response()->json([
               'success' => false,
               'message' => 'Ödeme talebi oluşturulurken bir hata oluştu.'
           ]);
       }
    }

}

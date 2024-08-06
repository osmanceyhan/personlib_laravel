<?php

namespace App\Http\Controllers\Admin\Moduls\Definations;

use App\Http\Controllers\Controller;
use App\Services\Definations\CountryService;
use App\Services\Definations\GeoCodeService;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    //

    use ApiResponser;

    protected $service;

    public function __construct(CountryService $service)
    {
        $this->service = $service;
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function index(){
        try{
            $process = $this->service->index();
            return $this->successResponse($process['data'],$process['status'],$process['message']);
        }catch (\Exception $e){
            return $this->errorResponse(__('api.operation_error'),500,showSummaryError($e));
        }
    }

}

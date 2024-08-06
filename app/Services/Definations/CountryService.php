<?php

namespace App\Services\Definations;

use App\Enumerations\BasicEnum;
use App\Models\Countries;
use App\Services\UploadService;
use Illuminate\Support\Facades\Cache;

class CountryService
{

    private UploadService $uploadService;

    public function __construct(){

        $this->model  = new Countries();

        $this->cache = Cache::remember('countries', now()->addWeek(1), function () {
            return $this->model->orderByDesc('id','asc')->get();
        });
    }


    public function index()
    {
        $models = $this->cache;
        if (!$models) {
            return [
                'data' => [],
                'status' => 400,
                'message' => __('api.operation_error')
            ];
        }
        return [
            'data' => $models,
            'status' => 200,
            'message' => __('api.success')
        ];
    }


    public function cacheClear(){
        Cache::forget('countries');
        $this->cache = Cache::remember('countries', now()->addWeek(1), function () {
            return $this->model->orderBy('id', 'asc')->get();
        });

    }


}

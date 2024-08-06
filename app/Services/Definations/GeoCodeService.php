<?php

namespace App\Services\Definations;

use App\Enumerations\BasicEnum;
use App\Models\BrandModels;
use App\Models\Brands;
use App\Models\Cars;
use App\Models\Fuels;
use App\Models\Gears;
use App\Models\GeoCodes;
use App\Models\MotorPowers;
use App\Models\Safes;
use App\Models\Segments;
use App\Services\EloquentServices\EloquentService;
use App\Services\UploadService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GeoCodeService
{

    private UploadService $uploadService;

    public function __construct(){

        $this->model  = new GeoCodes();
        $this->cacheKey = 'geo_codes';
        $this->cache = Cache::remember($this->cacheKey, now()->addWeek(1), function () {
            return $this->model->orderByDesc('sort','asc')->get();
        });

    }


    public function index()
    {
        $this->cacheClear();
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


    public function show($id)
    {
        $models = $this->cache->where('id',$id)->first();
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


    public function update($request,$id)
    {
        $models = $this->model->findOrFail($id);

        $models->fill($request);
        $models->save();
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
        $this->cacheClear();
    }



    public function store($request)
    {
        $models = $this->model->create($request);

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
        $this->cacheClear();
    }

    public function destroy($id){


        // Veritabanına kaydet
        $get = $this->model->whereId($id)->first();
        $status = $get->status == BasicEnum::ACTIVE->value ?
            BasicEnum::PASSIVE->value : BasicEnum::ACTIVE->value;
        $return = $this->model->whereId($id)->update(['status' => $status]);


        return [
            'data' => $return,
            'status' => 200,
            'message' => __('api.success')
        ];
        $this->cacheClear();

        return $return;

    }

    public function cacheClear(){
        $cacheKey = $this->cacheKey;
        Cache::forget($cacheKey);
        $this->cache = Cache::remember($cacheKey, now()->addWeek(1), function () {
            return $this->model->orderBy('sort', 'asc')->get();
        });

    }


}

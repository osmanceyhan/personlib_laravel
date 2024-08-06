<?php

namespace App\Services\Users;

use App\Models\Users\UserRules;
use App\Services\UploadService;
use Illuminate\Support\Facades\Cache;

class UserRuleService
{

    private UploadService $uploadService;
    public function __construct(){
        $this->model  = new UserRules();
        $this->cacheKey = 'user_rules';
        $this->cache = Cache::remember( $this->cacheKey, now()->addWeek(1), function () {
            return $this->model->orderByDesc('id','asc')->get();
        });
    }


    /**
     * @return array
     */
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


    /**
     * @return array
     */
    public function show($id)
    {
        $this->cacheClear();
        $models = $this->cache->where('id',$id);
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

    public function store($request)
    {

        $create = $this->model->create($request);
        if (!$create) {
            return [
                'data' => $create,
                'status' => 400,
                'message' => __('api.operation_error')
            ];
        }

        $this->cacheClear();
        return [
            'data' => $create,
            'status' => 201,
            'message' => __('api.success')
        ];
    }


    public function update($request,$id)
    {

        $model = $this->model->findOrFail($id);

        $model->fill($request);
        $model->save();  

        if (!$model) {
            return [
                'data' => [],
                'status' => 400,
                'message' => __('api.operation_error')
            ];
        }
        $this->cacheClear();

        return [
            'data' => $model,
            'status' => 202,
            'message' => __('api.success')
        ];
    }



    public function destroy($id)
    {

        $model = $this->model->findOrFail($id);

        $model->delete();

        if (!$model) {
            return [
                'data' => [],
                'status' => 400,
                'message' => __('api.operation_error')
            ];
        }
        $this->cacheClear();

        return [
            'data' => $model,
            'status' => 202,
            'message' => __('api.success')
        ];
    }

    public function cacheClear(){

        $cacheKey = $this->cacheKey;
        Cache::forget($cacheKey);
        $this->cache = Cache::remember( $cacheKey, now()->addWeek(1), function () {
            return $this->model->orderByDesc('id','asc')->get();
        });
    }


}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SortService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SortController extends Controller
{
    //
    private SortService $service;

    /**
     * @param SortService $service
     */
    public function __construct(SortService $service)
    {
        $this->service = $service;
    }

    public function update(Request $request)
    {
        $result = $this->service->update($request);
        Cache::forget('deals');
        return response()->json($result);

    }

}

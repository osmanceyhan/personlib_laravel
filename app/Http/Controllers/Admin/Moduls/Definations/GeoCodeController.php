<?php

namespace App\Http\Controllers\Admin\Moduls\Definations;

use App\Http\Controllers\Controller;
use App\Services\Definations\GeoCodeService;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeoCodeController extends Controller
{
    //

    use ApiResponser;

    protected $service;

    public function __construct(GeoCodeService $service)
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
            $results = $process['data'];
            return view(getAdminModule('definations.geo_codes.index'),compact('results'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }

    /**
     * @param $
     * @return JsonResponse
     */
    public function edit($id){
        try{
            $process = $this->service->show($id);
            $item = $process['data'];
            return view(getAdminModule('definations.geo_codes.edit'),compact('item'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function show($id){
        try{
            $process = $this->service->show($id);
            $results = $process['data'];
            return view(getAdminModule('definations.geo_codes.edit'),compact('results'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }

    /**
     * @param $
     * @return JsonResponse
     */
    public function create(){
        try{
            return view(getAdminModule('definations.geo_codes.create'));
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
            $process = $this->service->store(requestFilter($request->all()));
            return redirect()->route(getRouteWeb('geoCodes.index'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }

    /**
     * @param $
     * @return JsonResponse
     */
    public function update(Request $request,$id){
        try{
            $process = $this->service->update(requestFilter($request->all()),$id);
            $item = $process['data'];
            return view(getAdminModule('definations.geo_codes.edit'),compact('item'));
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
             $process = $this->service->destroy($id);
            $results = $process['data'];
            return redirect()->route(getRouteWeb('geoCodes.index'));
        }catch (\Exception $e){
             return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }

}

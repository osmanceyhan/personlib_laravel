<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Services\Settings\SettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    //

    private SettingsService $service;

    /**
     * @param SettingsService $service
     */
    public function __construct(SettingsService $service)
    {
        $this->service = $service;
    }


    public function index(){
        try{
            $results = $this->service->index();
            $filterHidden = function($item) {
                // Eğer gizli alan varsa, onu filtrele (remove)
                return !isset($item['hidden']);
            };

// Gizli alanları filtrele
            $results['forms'] = array_filter($results['forms'], $filterHidden);

// Dizinin anahtarlarını yeniden indisleyerek sıfırdan başlamasını sağla
            $results['forms'] = array_values($results['forms']);

            return view(getAdminView('settings.index'),$results);

        }catch (\Exception $e){
            dd($e);
            return redirect()->route(getRouteWeb('index'))->with('alert',['status' => 'danger','title' => 'Veriler Listelenemedi','message' => 'Lütfen teknik desteğe  başvurunuz.']);
        }
    }

    public function update(Request $request){
        try{
            $update = $this->service->update($request);
            return redirect()->back()->with('alert',['status' => 'success','title' => 'Güncelleme Başarılı.','message' => 'Veriler başarıyla güncellendi.']);
        }catch (\Exception $e){
            dd($e);
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'Veriler Listelenemedi','message' => 'Lütfen teknik desteğe  başvurunuz.']);
        }
    }
}

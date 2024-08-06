<?php

namespace App\Http\Controllers\Definations;

use App\Http\Controllers\Controller;
use App\Models\Company\Companies;
use App\Models\LeaveTypes;
use Illuminate\Http\JsonResponse;

class DefinationsController extends Controller
{
    //


    /**
     * @param $
     * @return JsonResponse
     */
    public function index(){
        try {

            $definations = [
                "leave_types" => [
                    'title' => 'İzin Türleri',
                    "count" => LeaveTypes::count(),
                    "route" => route('leave_types.index')
                ],
                "company" => [
                    'title' => 'Şirket Ayarları',
                    "count" => Companies::count(),
                    "route" => route('company.show')
                ],

            ];

            return view('definations.index',compact('definations'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('index')->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Listelenemedi!']);
        }
    }

}

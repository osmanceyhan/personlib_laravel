<?php

namespace App\Http\Controllers\Definations;

use App\Enumerations\BasicEnum;
use App\Http\Controllers\Controller;
use App\Models\Company\Companies;
use App\Models\LeaveTypes;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LeaveTypeController extends Controller
{
    //

    public function __construct()
    {
        $this->model = new LeaveTypes();
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function index(){
        try{
            $results = $this->model->all();
            return view('definations.leave_types.index',compact('results'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }


    public function leaveRequestsCalc(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        $companyId = $user->company_id;

        // Şirketin mesai başlangıç ve bitiş saatlerini al
        $company = Companies::find($companyId);
        $startTime = Carbon::parse($company->start_time); // Örn: 09:00
        $endTime = Carbon::parse($company->end_time); // Örn: 18:00

        // Kullanıcıdan gelen tarih ve saatleri al
        $startDate = Carbon::parse($request->start_date . ' ' . $request->start_time);
        $endDate = Carbon::parse($request->end_date . ' ' . $request->end_time);

        // Mesai saatlerini hesapla
        $totalHours = $this->calculateWorkingHours($startDate, $endDate, $startTime, $endTime);

        return response()->json(['total' => $totalHours]);
    }

    private function calculateWorkingHours($startDate, $endDate, $startTime, $endTime)
    {
        $totalHours = 0;
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            // Haftasonları hariç tut
            if ($date->isWeekend()) {
                continue;
            }

            // Günü hesapla
            $currentStart = $date->copy()->setTimeFrom($startTime);
            $currentEnd = $date->copy()->setTimeFrom($endTime);

            if ($date->isSameDay($startDate)) {
                $currentStart = $startDate->max($currentStart);
            }

            if ($date->isSameDay($endDate)) {
                $currentEnd = $endDate->min($currentEnd);
            }

            $totalHours += $currentStart->diffInHours($currentEnd);
        }

        return $totalHours;
    }

    /**
     * @param $
     * @return JsonResponse
     */
    public function edit($id){
        try{
            $item = $this->model->find($id);
            return view('definations.leave_types.edit',compact('item'));
        }catch (\Exception $e){
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Düzenlenemedi!']);
        }
    }


    /**
     * @param $
     * @return JsonResponse
     */
    public function show($id){
        try{
            $item = $this->model->find($id);
            return view('definations.leave_types.edit',compact('item'));
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
            return view('definations.leave_types.create');
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
                // Store
                $data = requestFilter($request->all());
                $process = $this->model->create($data);
                return redirect()->route('leave_types.index')->with('alert',['status' => 'success','title' => 'İşlem Başarılı','message' => 'Veri Oluşturuldu!']);
            }catch (QueryException $e){
                dd($e);
                return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Oluşturulamadı!']);
            }catch (\Exception $e){
                dd($e);

                return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Oluşturulamadı!']);
            }

    }

    /**
     * @param $
     * @return JsonResponse
     */
    public function update(Request $request,$id){
        try{
            $data = requestFilter($request->all());
            $item = $this->model->find($id)->update($data);
            return redirect()->route('leave_types.index')->with('alert',['status' => 'success','title' => 'İşlem Başarılı','message' => 'Veri Güncellendi!']);
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
            // Statu degistirir
            $get = $this->model->whereId($id)->first();
            $status = $get->status == BasicEnum::ACTIVE->value ?
                BasicEnum::PASSIVE->value : BasicEnum::ACTIVE->value;
            $return = $this->model->whereId($id)->update(['status' => $status]);
            return redirect()->route('geoCodes.index');
        }catch (\Exception $e){
             return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }

}

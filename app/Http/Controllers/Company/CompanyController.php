<?php

namespace App\Http\Controllers\Company;

use App\Enumerations\BasicEnum;
use App\Http\Controllers\Controller;
use App\Models\Company\Companies;
use App\Models\LeaveTypes;
use App\Models\User;
use App\Services\UploadService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    //

    public function __construct()
    {
        $this->model = new Companies();
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
    public function show(){
        try{
            $user = User::where('id',Auth::id())->first();

            $companyId = $user->company_id;

            $item = $this->model->find($companyId);
            return view('company.index',compact('item'));
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
    public function update(Request $request){
        try{
            $user = User::where('id',Auth::id())->first();
            $companyId = $user->company_id;

            $uploadService = new UploadService();
            $data = requestFilter($request->all());
            if ($request->hasFile('logo')) {
                $fileName = $uploadService
                    ->setModule('companies')
                    ->upload($request->file('logo'));
                $data['logo'] = $fileName;
            }
            $item = $this->model->find($companyId)->update($data);
            return redirect()->back()->with('alert',['status' => 'success','title' => 'İşlem Başarılı','message' => 'Veri Güncellendi!']);
        }catch (\Exception $e){
            dd($e);
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

<?php

namespace App\Http\Controllers\Admin\Users;

use App\Enumerations\ApprovalEnum;
use App\Enumerations\CampaignEnum;
use App\Enumerations\DiscountTypeEnum;
use App\Enumerations\MemberPermissionEnum;
use App\Enumerations\NationalityEnum;
use App\Enumerations\SendEnum;
use App\Enumerations\UsersEnum;
use App\Enumerations\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Contents\Pages\Pages;
use App\Services\Users\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class UsersController extends Controller
{

    private UserService $service;

    /**
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->limit = 999;
            $user_type = UserTypeEnum::PERSONAL->value;
            $request->user_type = $user_type;

            $results = $this->service->index($request);
            return view(getAdminView('users.index'),compact('results','user_type'));
        } catch (QueryException $e) {
            return redirect()->route(getRouteWeb('index'))->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veritabanı Hatası!']);
        } catch (\Exception $e) {
            return redirect()->route(getRouteWeb('index'))->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Listelenemedi!']);
        }
    }



    /**
     * Search a listing of the resource.
     */
    public function search(Request $request)
    {
        try {

            $results = $this->service->search($request);
            return $results;
        } catch (QueryException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function corporates(Request $request)
    {
        try {
            $request->limit = 999;
            $user_type = UserTypeEnum::CORPORATE->value;
            $request->user_type = $user_type;
            $results = $this->service->index($request);
            return view('users.index',compact('results','user_type'));
        } catch (QueryException $e) {
            return redirect()->route(getRouteWeb('index'))->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veritabanı Hatası!']);
        } catch (\Exception $e) {
            return redirect()->route(getRouteWeb('index'))->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Listelenemedi!']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        try {
            return view('users.create');
        } catch (QueryException $e) {
            return redirect()->route('users.index')->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veritabanı Hatası!']);
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Listelenemedi!']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $results = $this->service->store($request);

            return redirect()->route('users.index')->with('alert',['status' => 'success','title' => 'İşlem Başarılı','message' => 'Veri başarıyla eklendi.']);
        } catch (QueryException $e) {
            return redirect()->route('users.index')->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veritabanı Hatası!']);
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Eklenemedi!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $item = $this->service->show($id);
            $compact = [
                'item' => $item,
                'nationalities' => NationalityEnum::allStatus(),
                'user_enums' => UsersEnum::allStatus(),
                'user_type_enums' => UserTypeEnum::allStatus(),
                'send_enums' =>  SendEnum::allStatus(),
                'approval_enums' => ApprovalEnum::allStatus(),
                'permission_enums' => MemberPermissionEnum::allStatus(),
                'contracts' => setCache('contracts',Pages::where('category_id',1)->get()),
                'campaign_enums' => CampaignEnum::allStatus(),
                'discount_type_enums' => DiscountTypeEnum::allStatus(),
                'reservations' => $item->reservations,
                'logs' => Activity::where('log_name','users')->get(),
            ];
            return view('users.edit',$compact);
        } catch (QueryException $e) {

            return redirect()->route('users.index')->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veritabanı Hatası!']);
        } catch (\Exception $e) {

            return redirect()->route('users.index')->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Listelenemedi!']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $results = $this->service->update($request,$id);
            if($results['status'] == "error"){
                return redirect()->back()->with('alert', [
                    'status' => 'danger',
                    'title' => 'İşlem Başarısız',
                    'message' => $results['message'],
                    'active_tab' => $request->active_tab,
                ]);
            }else{
                return redirect()->back()->with('alert', [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => $results['message'],
                    'active_tab' => $request->active_tab,
                ]);
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'status' => 'danger',
                'title' => 'İşlem Başarısız',
                'message' => 'Veri Güncellenemedi ',
                'active_tab' => $request->active_tab,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $results = $this->service->destroy($id);
            return redirect()->back()->with('alert',['status' => 'success','title' => 'İşlem Başarılı','message' => 'Veri Başarıyla Pasifleştirildi']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert',['status' => 'danger','title' => 'İşlem Başarısız','message' => 'Veri Silinemedi!']);
        }
    }
}

<?php
namespace App\Services\Users;

use App\Enumerations\BasicEnum;
use App\Enumerations\ReservationsEnum;
use App\Enumerations\UsersEnum;
use App\Enumerations\UserTypeEnum;
use App\Mail\MemberPasswordUpdated;
use App\Models\Admins;
use App\Services\EloquentServices\EloquentService;
use App\Services\UploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Activitylog\Models\Activity;

class UserService
{

    private UploadService $uploadService;

    public function __construct(User $model,UploadService  $uploadService){
        $this->model  = $model;
        $this->cache = Cache::remember('users', now()->addWeek(1),
            function ()  {
                return $this->model->all();
            });

        $this->uploadService = $uploadService;
    }

    public function profile(){
        $profile = User::where('id',auth('api')->id())->first();

        if (!$profile) {
            return [
                'data' => [],
                'status' => 400,
                'message' => __('api.operation_error')
            ];
        }
        return [
            'data' => $profile,
            'status' => 200,
            'message' => __('api.success')
        ];
    }

    public function myTransfers(){

        $transferService = new TransferService();
        $transferService->cacheClear();
        $results     = $transferService->cache->where('user_id',auth('api')->id())
            ->where('status','!=',ReservationsEnum::WAITING->value);

        if (!$results) {
            return [
                'data' => [],
                'status' => 400,
                'message' => __('api.operation_error')
            ];
        }
        return [
            'data' => $results,
            'status' => 200,
            'message' => __('api.success')
        ];
    }





    public function index($request)
    {
        $this->cacheClear();

        $models = $this->cache;
        $filter = json_decode($request->filters);
        $sortable = json_decode($request->sortable);

        $limit = $request->limit ?? null;

        if($request->has("limit") AND !is_null($request->getLimit())){
            $limit = $request->limit;
        }
        $user_type = $request->user_type ? $request->user_type : UserTypeEnum::PERSONAL->value;
        $models = $models->where('user_type',$user_type);

        if ($request->has("filters") AND !is_null($request->filters)){
            $models = (new EloquentService($this->model,json_decode($request->filters),$models))->filter();
        }


        if($request->has("sortable") AND !is_null($request->sortable)){
            $models = $models->sortable(json_decode($request->sortable,true));
        }



        $data = $models;
        return  $data;
    }


    public function switchDarkMode($request){
        $admin = Admins::whereId(Auth::id())->update([
           'dark_mode' => $request->mode,
           'dark_mode_required' => BasicEnum::ACTIVE->value
        ]);
        return ['success' => true];
    }


    public function search($request)
    {
        $this->cacheClear();

        $models = $this->cache;

        $keyword = $request->term;

        $models = $this->model->where('email', 'like', "%$keyword%")
            ->orWhere('name', 'like', "%$keyword%")
            ->orWhere('surname', 'like', "%$keyword%")
            ->orWhere('id', 'like', "%$keyword%")
            ->get();
            $models->map(function($value,$key){
                $value->fullName = $value->fullName();
                $value->showUser = $value->showUser();
                $value->showFullUser = $value->showFullUser();

            });
        $data = $models;
        return  $data;
    }

    public function show($id){
        $models = $this->cache;

        $data = $models->find($id);
        return  $data;
    }

    public function store($request){
        // Gelen veriyi düzenle
        $data = $request->all();

        // Veritabanına kaydet
        $return = $this->model->create($data);
        $this->cacheClear();
        return $return;

    }

    public function update($request,$id){
        // Gelen veriyi düzenle
        $data = $request->all();

        if(!isset($data['password'])){
            if($data['password'] != $data['password_again']){
                return ['status' => 400,'data' => '','message' => 'Yeni şifre uyuşmuyor!' ];
            }
        }

        if(isset($data['current_password'])){
            if(!Hash::check($data['current_password'], User::whereId($id)->first()->password)){
                return ['status' => 400,'data' => '','message' => 'Mevcut şifre hatalı!' ];
            }

        }


        if(isset($data['password'])){
            // Yeni şifreyi al
            $user = $this->model->find($id);
            $data['password'] = Hash::make($data['password']);

            // E-posta gönder
          //  Mail::to($user->email)->send(new MemberPasswordUpdated($newPassword));

        }
        unset($data["send_email"]);
        unset($data["password_again"]);
        unset($data["active_tab"]);

        unset($data["_token"]);
        unset($data["_method"]);
        // Veritabanına kaydet

        $modelData = $this->model::whereId($id);
        $old = $modelData->first();
        $return = $modelData->first()?->update($data); //if you are using php >= 8
        $new = $modelData->first();


        if(!$return){
            return ['status' => 400,'data' => '','message' => 'Veri güncellenemedi!' ];

        }

        activity()
            ->performedOn( $old )
            ->causedBy(Auth::user())
            ->withProperties(['old' => $old,'new' => $new])
            ->useLog('users')
            ->setEvent('updated')
            ->log($old->id.' numaralı ( :subject.name ) kullanıcı bilgileri güncellendi');


        Cache::forget('users');
        return ['status' => 200,'data' => '','message' => 'Veri Başarıyla Güncellendi' ];


    }

    public function cacheClear(){
        Cache::forget('users');

        $this->cache = Cache::remember('users', now()->addWeek(1),
            function ()  {
                return $this->model->all();
            });


    }

    public function destroy($id){


        // Veritabanına kaydet
        $get = $this->model->whereId($id)->first();
        $status = $get->status == UsersEnum::ACTIVE->value ?
            UsersEnum::BANNED->value : UsersEnum::ACTIVE->value;
        $return = $this->model->whereId($id)->update(['status' => $status]);
        $this->cacheClear();

        return $return;

    }

}

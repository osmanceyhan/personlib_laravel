<?php
namespace App\Services\Users;

use App\Enumerations\BasicEnum;
use App\Enumerations\UsersEnum;
use App\Enumerations\UserTypeEnum;
use App\Mail\MemberPasswordUpdated;
use App\Enumerations\CampaignEnum;
use App\Models\UsersCampaigns;
use App\Services\EloquentServices\EloquentService;
use App\Services\UploadService;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserCampaignService
{

    private UploadService $uploadService;

    public function __construct(UsersCampaigns $model,User $user,UploadService  $uploadService){
        $this->model  = $model;
        $this->cacheKey = 'users_campaigns';
        $this->cache = Cache::remember($this->cacheKey, now()->addWeek(1),
            function ()  {
                return $this->model->all();
            });
        $this->coupons = Cache::remember("coupons", now()->addWeek(1),
            function ()  {
                return $this->model->all();
            });

        $this->user = Cache::remember('users', now()->addWeek(1),
            function () use($user)  {
                return $user->all();
            });
        $this->uploadService = $uploadService;
    }


    public function index($request)
    {
        $this->cacheClear();

        $models = new UsersCampaigns();
        $filter = json_decode($request->filters);
        $sortable = json_decode($request->sortable);

        $limit = $request->limit ?? null;

        if($request->has("limit") AND !is_null($request->getLimit())){
            $limit = $request->limit;
        }
        $user_type = $request->user_type ? $request->user_type : UserTypeEnum::PERSONAL->value;
        $models = $models->join('users','users.id','=','users_campaigns.user_id');
        $models = $models->select('users_campaigns.*','users.id as user_id','users.user_type','users.name','users.surname','users.email','users.status as user_status');

        if($user_type != "all") {
            $models = $models->where('users.user_type', $user_type);
        }

        if ($request->has("filters") AND !is_null($request->filters)){
            $models = (new EloquentService($this->model,json_decode($request->filters),$models))->filter();
        }


        if($request->has("sortable") AND !is_null($request->sortable)){
            $models = $models->sortable(json_decode($request->sortable,true));
        }




        $data = $models->get();
        return  $data;
    }

    public function show($id){
        $models = $this->cache;

        $data = $models->find($id);
        return  $data;
    }

    private function performChecks($data)
    {

        if ($data['type'] == CampaignEnum::COUPON->value) {
            // Kupon kodu girilmiş ise kupon var mı yok mu?
            $existingCoupon = $this->coupons
                ->where('code', $data['coupon_code'])
                ->first();
            if(!$existingCoupon){
                throw new \Exception('Tanımlı olmayan bir kupon kodu girdiniz!');
            }
            if($existingCoupon && $existingCoupon->status != BasicEnum::ACTIVE->value){
                throw new \Exception('Aktif olmayan bir kupon kodu girdiniz!');
            }
        }
        // Eğer yeni kampanya tipi DISCOUNT ise
        if ($data['type'] == CampaignEnum::DISCOUNT->value) {
            // Tarih sınırlaması olmayan (is_date = PASSIVE) bir kampanya var mı kontrol et
            $existingNonDateLimitedCampaign = $this->model
                ->where('user_id', $data['user_id'])
                ->where('type', CampaignEnum::DISCOUNT->value)
                ->where('is_date_limit', BasicEnum::PASSIVE->value)
                ->first();

            if ($existingNonDateLimitedCampaign) {
                // Tarih sınırlaması olmayan bir kampanya zaten varsa hata ver
                throw new \Exception('Zaten tarih sınırlaması olmayan bir kampanya mevcut, lütfen önceki kampanyayı kapatıp tekrar deneyin!');
            }





            // Aktif olan bir kampanya var mı kontrol et
            $existingActiveCampaign = $this->model
                ->where('user_id', $data['user_id'])
                ->where('type', CampaignEnum::DISCOUNT->value)
                ->where('status', BasicEnum::ACTIVE->value)
                ->where(function ($query) use ($data) {
                    $query->whereBetween('start_at', [$data['start_at'], $data['end_at']])
                        ->orWhereBetween('end_at', [$data['start_at'], $data['end_at']]);
                })
                ->first();

            if ($existingActiveCampaign) {
                // Aktif bir kampanya varsa hata ver
                throw new \Exception('Bu tarih aralığında başka bir kampanya mevcut, lütfen önceki kampanyayı kapatın veya tarih aralığınızı değiştirin');
            }
        }
    }



    private function handleError($request, $status, $message)
    {
        if ($request->refferal_page) {
            return redirect()->route($request->refferal_page, $request->user_id)
                ->with('alert', ['active_tab' => $request->active_tab, 'status' => $status, 'title' => 'İşlem Başarısız', 'message' => $message]);
        }

        return redirect()->route('users.campaigns.index')
            ->with('alert', ['status' => $status, 'title' => 'İşlem Başarısız', 'message' => $message]);
    }
    public function store($request){
        // Gelen veriyi düzenle
        $data = $request->all();

        // Kontrolleri gerçekleştir
        $this->performChecks($data);

        // Veritabanına kaydet

        $return = $this->model->create($data);
        $this->cacheClear();
        return $return;

    }

    public function update($request,$id){
        // Gelen veriyi düzenle
        $data = $request->all();

        unset($data["_token"]);
        unset($data["_method"]);
        // Veritabanına kaydet
        $update = $this->model::where("id", $id)->first()?->update($data); //if you are using php >= 8


        $this->cacheClear();
        return ['status' => "success",'data' => $update,'message' => 'Veri Başarıyla Güncellendi' ];

    }

    public function cacheClear(){
        Cache::forget($this->cacheKey);

        $this->cache = Cache::remember($this->cacheKey, now()->addWeek(1),
            function ()  {
                return $this->model->all();
            });


    }

    public function destroy($id){


        // Veritabanına kaydet
        $get = $this->model->whereId($id)->first();
        $status = $get->status == BasicEnum::ACTIVE->value ?
            BasicEnum::PASSIVE->value : BasicEnum::ACTIVE->value;
        $return = $this->model->whereId($id)->update(['status' => $status]);
        $this->cacheClear();

        return $return;

    }

}

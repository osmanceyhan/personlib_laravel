<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Enumerations\BasicEnum;
use App\Enumerations\UsersEnum;
use App\Enumerations\ApprovalEnum;
use App\Enumerations\UserTypeEnum;

if(!function_exists('requestFilter')){
    function requestFilter($request){
        if(isset($request['_token'])){
            unset($request['_token']);
        }
        if(isset($request['_method'])){
            unset($request['_method']);
        }
        return $request;
    }
}

if(!function_exists('imageToBase64')){
    function imageToBase64($imagePath){
        $type = pathinfo($imagePath, PATHINFO_EXTENSION);
        $data = file_get_contents($imagePath);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}

if (!function_exists('showDateTime')) {

    function showDateTime($date,$global=false)
    {
        if($global){
            return Carbon::parse($date)->format('d.m.Y H:i');
        }
        setlocale(LC_ALL, 'tr_TR');
        Carbon::setLocale("tr_TR");

        // Carbon nesnesini oluştur
        $carbonDate = Carbon::parse($date)->locale('tr_TR');

        // Türkçe tarih ve saat formatında göster
        return $carbonDate->format('j M Y H:i');
    }
}

if(!function_exists('showSummaryError')){
    function showSummaryError($e){
        return $e->getMessage().' - '.$e->getLine();
    }
}




if (!function_exists('showDate')) {

    function showDate($date)
    {
        setlocale(LC_ALL, 'tr_TR');
        Carbon::setLocale("tr_TR");

        // Carbon nesnesini oluştur
        $carbonDate = Carbon::parse($date)->locale('tr_TR');

        // Türkçe tarih ve saat formatında göster
        return $carbonDate->format('j M Y');
    }
}




if (!function_exists('getStatus')) {

    function getStatus($status)
    {
        $status = BasicEnum::getDetail($status);
        $colors = $status['colors']['primary'];
        $style = "background:".$colors["background_color"].";color:".$colors["text_color"];
        return '<div class="badge bg-pill  font-size-12" style="'.$style.'".>'.$status["value"].'</div>';
    }
}






if (!function_exists('getCompanyLogo')) {

    function getCompanyLogo()
    {

        if(\Illuminate\Support\Facades\Auth::check()){
            $user = \Illuminate\Support\Facades\Auth::user();
            if($user->getCompany){
                return $user->getCompany->logo ? getCdn($user->getCompany->logo) : asset('assets/images/personlib.svg');
            }
        }else{
            return asset('assets/images/personlib.svg');
        }
    }
}

if (!function_exists('getApprovalStatus')) {

    function getApprovalStatus($status)
    {
        $status = ApprovalEnum::getDetail($status);
        $colors = $status['colors']['primary'];
        $style = "background:".$colors["background_color"].";color:".$colors["text_color"];
        return '<div class="badge bg-pill  font-size-12" style="'.$style.'".>'.$status["value"].'</div>';
    }
}

if (!function_exists('getUserTypeStatus')) {

    function getUserTypeStatus($status)
    {
        $status = UserTypeEnum::getDetail($status);
        $colors = $status['colors']['primary'];
        $style = "background:".$colors["background_color"].";color:".$colors["text_color"];
        return '<div class="badge bg-pill  font-size-12" style="'.$style.'".>'.$status["value"].'</div>';
    }
}

if (!function_exists('getUserStatus')) {

    function getUserStatus($status,$style=null)
    {
        $status = UsersEnum::getDetail($status);
        $colors = $status['colors']['primary'];
        $style = "background:".$colors["background_color"].";color:".$colors["text_color"];
        if(!$style == null){
            return '<span class="badge  font-size-12" style="'.$style.'">'.$status["value"].'</span>';
        }

        return '<div class="badge bg-pill  font-size-12" style="'.$style.'".>'.$status["value"].'</div>';
    }
}

if (!function_exists('showDate')) {

    /**
     * @param $date
     * @return mixed
     */
    function showDate($date)
    {
        // Carbon nesnesini oluştur
        $carbonDate = Carbon::parse($date);

        // Türkçe tarih formatında göster
        return $carbonDate->format('j F Y');
    }
}
if (!function_exists('getAvatar')) {
    function getAvatar()
    {
        if(\Illuminate\Support\Facades\Auth::check()){
            $user = \Illuminate\Support\Facades\Auth::user();
            if(!$user->avatar){
                return asset('assets/images/noavatar.svg');
            }
            return getCdn($user->avatar);
        }
        return asset('assets/images/noavatar.svg');
    }
}


if (!function_exists('getCdn')) {
    function getCdn($imagePath,$nullPath=false)
    {
        $disk = config('filesystems.default');

        if($disk == 'public'){
            return asset('storage/'.$imagePath);
        }

        $cdnBaseUrl = config('image.storage_asset_url');
        $cdnBaseDir = config('image.cdn_base_dir');
        $defaultImage = asset('assets/images/noimage.jpeg'); // Varsa bir default resim belirleyebilirsiniz
        $fullImagePath= false;
        if ($imagePath) {
            $fullImagePath = rtrim($cdnBaseUrl, '/') . rtrim($cdnBaseDir, '/') . '/' . ltrim($imagePath, '/');
            // Eğer tam resim yolu içinde iki ardışık "https://cdn.cappadociavisitor.com/images/" ifadesi varsa birini sil
            $fullImagePath = str_replace('https://cdn.cappadociavisitor.com/images/https://cdn.cappadociavisitor.com/images/', 'https://cdn.cappadociavisitor.com/images/', $fullImagePath);
         return $fullImagePath;
        }
        if($nullPath){
            return $imagePath;
        }



        // Eğer $imagePath boşsa veya resim yüklenmiyorsa, default resmi kullan
        return $defaultImage ?? ''; // Varsa belirtilen default resmi, yoksa boş string
    }
}

if (!function_exists('status_color')) {
    /**
     * @param $colorType
     * @param $type
     * @param $typeSub
     * @return string
     */
    function status_color($colorType = "primary", $type = 'success',$typeSub = "text"):string
    {
        $colors = [
            "primary"=>[
                "success" => [
                    "text" => "#34c38f",
                    "background"    => "rgba(52,195,143,.18)",
                    "border"        => "#6aa842"
                ],
                "danger"    => [
                    "text" => "#f46a6a",
                    "background"    => "rgba(244,106,106,.18)",
                    "border"        => "#F4F4F4"
                ],
                "pending"   => [
                    "text" => "#F4F4F4",
                    "background"    => "#e59741",
                    "border"        => "#e59741"
                ]
            ],
            "secondary"=>[
                "success" => [
                    "text" => "#F4F4F4",
                    "background"    => "#FCBB0733",
                    "border"        => "#F4F4F4"
                ],
                "danger"    => [
                    "text" => "#F4F4F4",
                    "background"    => "#FCBB0734",
                    "border"        => "#F4F4F4"
                ],
                "pending"   => [
                    "text" => "#F4F4F4",
                    "background"    => "#FCBB0735",
                    "border"        => "#F4F4F4"
                ]
            ],
            "default"=>[
                "success" => [
                    "text" => "#F4F4F4",
                    "background"    => "#FCBB0733",
                    "border"        => "#F4F4F4"
                ],
                "danger"    => [
                    "text" => "#F4F4F4",
                    "background"    => "#FCBB0734",
                    "border"        => "#F4F4F4"
                ],
                "pending"   => [
                    "text" => "#F4F4F4",
                    "background"    => "#FCBB0735",
                    "border"        => "#F4F4F4"
                ]
            ],
        ];
        return $colors[$colorType][$type][$typeSub];
    }
}

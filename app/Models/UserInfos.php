<?php

namespace App\Models;

use App\Models\Company\Companies;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfos extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'company_id', 'title', 'start_date', 'contract_type', 'end_date', 'work_type', 'birthdate', 'tc_number', 'military_status', 'military_done_date', 'military_postponement_date', 'educational_status', 'education_complete_status', 'marital_status', 'children_count', 'adress', 'adress_two', 'city', 'country', 'zip_code', 'address_phone', 'bank_name', 'bank_type', 'bank_iban', 'bank_number', 'emergency_fullname', 'emergency_phone', 'emergency_proximity_degree', 'created_at', 'updated_at', 'deleted_at'];

    protected $table = 'user_infos';


    public function workTime()
    {
        // Start date calculator format 3 yıl 5 ay 5 gün şeklinde
        $start_date = new \DateTime($this->start_date);
        $interval = $start_date->diff(new \DateTime());
        if($this->end_date){
            $end_date = new \DateTime($this->end_date);
            $interval = $start_date->diff($end_date);
        }

        $years = $interval->format('%y');
        $months = $interval->format('%m');
        $days = $interval->format('%d');
        return $years . ' yıl ' . $months . ' ay ' . $days . ' gün';
    }

    public  function calculateAnnualLeaveDays()
    {
        // Mevcut tarihi al
        $currentDate = Carbon::now();

        // Kullanıcının işe başlama tarihini al
        $employmentStartDate = Carbon::parse($this->start_date);

        // İşe başlama tarihinden itibaren geçen yıl sayısını hesapla
        $yearsWorked = $currentDate->diffInYears($employmentStartDate);

        // Her yıl için 14 gün izin tanımla
        $annualLeaveDays = $yearsWorked * 14;

        return $annualLeaveDays;
    }

    public function getCompany()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }

    public function getCompanyTitle()
    {
        return $this->getCompany ? $this->getCompany->title : '';
    }

    public function getCompanyManagerName()
    {
        return $this->getCompany ? $this->getCompany->getManager->fullName() : '';
    }
    public function getCompanyManagerTitle()
    {
        return $this->getCompany ? $this->getCompany->getManagerInfo->title : '';
    }
    public function getManagerAvatar()
    {
        return $this->getCompany ? $this->getCompany->getManager->getAvatar() : '';
    }
}

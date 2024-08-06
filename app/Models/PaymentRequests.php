<?php

namespace App\Models;

use App\Models\Company\Companies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequests extends Model
{
    use HasFactory;

    protected $fillable = ['id','company_id', 'user_id', 'payment_type', 'amount', 'used_date', 'attachment', 'comment', 'tax_rate', 'receipt_date', 'start_date', 'start_time', 'hour', 'minute','status','payment_status', 'created_at', 'updated_at', 'deleted_at'];

    protected $table = 'payment_requests';
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function getCompany()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }
}

<?php

namespace App\Models\Company;

use App\Models\User;
use App\Models\UserInfos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'owner_id',
        'name',
        'title',
        'logo',
        'address',
        'phone',
        'start_time',
        'end_time',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $table = 'companies';

    public function getManager()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function getManagerInfo()
    {
        return $this->hasOne(UserInfos::class, 'user_id', 'owner_id');
    }


}

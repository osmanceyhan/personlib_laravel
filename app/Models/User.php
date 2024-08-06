<?php

namespace App\Models;

use App\Models\Company\Companies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected  $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'company_id',
        'name',
        'surname',
        'email',
        'gender',
        'verify_token',
        'email_verified_at',
        'avatar',
        'password',
        'phone',
        'title',
        'company_name',
        'user_role', // 'ADMIN','MANAGER','EMPLOYEE'
        'company_title',
        'employees_count',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function fullName()
    {
        return $this->name.' '.$this->surname;
    }

    public function getCompany()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }
    public function getUserInfo()
    {
        return $this->hasOne(UserInfos::class, 'user_id', 'id');
    }



    public function getAvatar()
    {
            if(!$this->avatar){
                return asset('assets/images/noavatar.svg');
            }
            return getCdn($this->avatar);

    }

}

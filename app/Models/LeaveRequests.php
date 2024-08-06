<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequests extends Model
{
    use HasFactory;

    protected $fillable = ['id','company_id', 'user_id', 'leave_type_id', 'start_date', 'start_time', 'end_date', 'end_time', 'comment', 'person_replace_id','total', 'return_date', 'return_time','status','rejected_comment', 'created_at', 'updated_at', 'deleted_at'];

    protected $table = 'leave_requests';

    public function leaveType()
    {
        return $this->hasOne(LeaveTypes::class, 'id', 'leave_type_id');
    }

    public function getUser(){
        return $this->hasOne(User::class,'id','user_id');
    }

}

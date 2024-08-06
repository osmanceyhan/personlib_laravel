<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveTypes extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'gender','type', 'price_type', 'description', 'days', 'status', 'created_at', 'updated_at', 'deleted_at'];

    protected $table = 'leave_types';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'type', 'log', 'targetClass', 'created_at', 'updated_at', 'deleted_at'];

    protected $table = 'logs';
}

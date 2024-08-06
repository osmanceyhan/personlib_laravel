<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Migrations extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'migration', 'batch'];

    protected $table = 'migrations';
}

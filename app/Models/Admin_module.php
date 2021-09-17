<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_module extends Model
{
    use HasFactory;
    protected $fillable = ['id','admin_id','role_id','module'];
}

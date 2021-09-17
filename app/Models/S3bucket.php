<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class S3bucket extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
}

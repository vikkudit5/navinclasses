<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_category extends Model
{
    use HasFactory;
    protected $fillable = ['parent_id','product_id','admin_id','name','description','type','image','slug','sort_order','status']; 
}

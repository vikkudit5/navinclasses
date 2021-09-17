<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    protected $fillable = ['parent_id','product_id','admin_id','name','description','type','image','slug','sort_order','status'];  
}

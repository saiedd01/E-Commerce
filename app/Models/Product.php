<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name","desc","image","price","category_id","quantity","Discount"
    ];

    protected $date=['deleted_at'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(cart::class);
    }
}

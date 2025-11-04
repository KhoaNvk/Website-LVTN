<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $fillable = ['CategoryName','CategorySlug','CategoryImage'];
    protected $primaryKey = 'idCategory';
    protected $table = 'category';

public function brands()
{
    return $this->belongsToMany(Brand::class, 'brand_category', 'idCategory', 'idBrand');
}

    // public function product(){
    //     return $this->hasMany('App\Models\Product');
    // }
}

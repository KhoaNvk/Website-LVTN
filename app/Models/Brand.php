<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamp = false;
    protected $fillable = ['BrandName','BrandSlug','BrandImage'];
    protected $primaryKey = 'idBrand';
    protected $table = 'brand';

    public function categories()
{
    return $this->belongsToMany(Category::class, 'brand_category', 'idBrand', 'idCategory');
}

    // public function product(){
    //     return $this->hasMany('App\Models\Product');
    // }
}

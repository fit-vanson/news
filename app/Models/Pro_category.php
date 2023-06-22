<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pro_category extends Model
{
    use HasFactory;

    protected $table= 'pro_categories';


    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'subheader_image',
        'description',
        'layout',
//        'lan',
        'parent_id',
        'is_subheader',
        'is_publish',
        'og_title',
        'og_image',
        'og_description',
        'og_keywords',
    ];


    public function products(){
        return $this->hasMany(Product::class,'cat_id');
    }

    public function site(){
        return $this->belongsToMany(MultipleSites::class,MultipleSites_Categories::class,'category_id','multiple_site_id');
    }

}

<?php

namespace App\Models;

use App\Http\Controllers\Backend\SectionManageController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleSites extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_name',
        'site_web',
        'is_publish',
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($site) {
            $site->categories()->delete();
            $site->site_options()->delete();
        });
    }


    public function tp_status(){
        return $this->belongsTo(Tp_status::class,'is_publish');
    }
//    public function categories(){
//        return $this->belongsToMany(Pro_category::class,MultipleSites_Categories::class,'multiple_site_id','category_id');
//    }


    public function categories()
    {
        return $this->hasMany(Categories::class,'site_id');
    }

    public function news()
    {
        return $this->hasManyThrough(News::class, Categories::class, 'site_id', 'category_id');
    }

    public function site_options(){
        return $this->hasOne(Site_option::class,'site_id');
    }

    public function social_medias(){
        return $this->hasMany(Social_media::class,'site_id');
    }

    public function section_manage(){
        return $this->belongsToMany(Section_manage::class,SiteSectionManages::class,'site_id','section_id')->withPivot('desc','title','image','url','is_publish');
    }


    public function sliders(){
        return $this->hasMany(Slider::class,'site_id');
    }

    public function offer_ads(){
        return $this->hasMany(Offer_ad::class,'site_id');
    }

}

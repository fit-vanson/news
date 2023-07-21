<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleSites extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_web',
        'is_publish',
        'note',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($site) {
            $site->categories()->delete();
            $site->site_options()->delete();
        });
    }


    public function tp_status()
    {
        return $this->belongsTo(Tp_status::class, 'is_publish');
    }


    public function categories()
    {
        return $this->hasMany(Categories::class, 'site_id');
    }

    public function news()
    {
        return $this->hasManyThrough(News::class, Categories::class, 'site_id', 'category_id');
    }

    public function site_options()
    {
        return $this->hasOne(Site_option::class, 'site_id');
    }





}

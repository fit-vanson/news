<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tp_status()
    {
        return $this->belongsTo(Tp_status::class, 'is_publish');
    }

    public function hot_news()
    {
        return $this->belongsTo(Tp_status::class, 'breaking_news');
    }


    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trackNews()
    {
        return $this->hasMany(TrackNewsUrl::class, 'news_id');
    }


    public function site()
    {
        return $this->belongsTo(MultipleSites::class, 'site_id');
    }

}

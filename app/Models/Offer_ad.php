<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer_ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'offer_ad_type',
        'title',
        'url',
        'image',
        'desc',
        'is_publish',
    ];

    public function tp_status(){
        return $this->belongsTo(Tp_status::class,'is_publish');
    }
}

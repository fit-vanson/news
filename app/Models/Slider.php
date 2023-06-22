<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'slider_type',
        'url',
        'image',
        'title',
        'desc',
        'is_publish',
    ];

    public function tp_status(){
        return $this->belongsTo(Tp_status::class,'is_publish');
    }

}

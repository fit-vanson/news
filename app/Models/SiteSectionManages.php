<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSectionManages extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_id',
        'section_id',
        'title',
        'image',
        'desc',
        'is_publish',
        'url',
    ];

    public function tp_status(){
        return $this->belongsTo(Tp_status::class,'is_publish');
    }
}

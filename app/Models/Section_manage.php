<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section_manage extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'title',
        'image',
        'desc',
        'is_publish',
    ];


    public function tp_status(){
        return $this->belongsTo(Tp_status::class,'is_publish');
    }

    public function site(){
        return $this->belongsToMany(MultipleSites::class,SiteSectionManages::class,'section_id','site_id')->withPivot(
            'desc','title','image','url','is_publish'
        );
    }

    public function site_section_manages(){
        return $this->hasOne(SiteSectionManages::class,'section_id');
    }
}

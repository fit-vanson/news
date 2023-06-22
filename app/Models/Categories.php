<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function tp_status(){
        return $this->belongsTo(Tp_status::class,'is_publish');
    }

    public function news()
    {
        return $this->hasMany(News::class,'category_id');
    }
}

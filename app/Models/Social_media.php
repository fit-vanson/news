<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social_media extends Model
{
    use HasFactory;

	protected $table = 'social_medias';

    protected $fillable = [
        'site_id',
        'title',
		'url',
		'social_icon',
		'target',
		'is_publish'
    ];

    public function tp_status(){
        return $this->belongsTo(Tp_status::class,'is_publish');
    }
}

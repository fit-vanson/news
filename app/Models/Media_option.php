<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media_option extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'alt_title',
        'thumbnail',
        'large_image',
        'option_value',
        'hash_image',
    ];


    public static function getMediaOptionWithoutHash($limit = null, $offset = null)
    {
        $query = self::query()->whereNull('hash_image')->orderBy('id');

        if ($limit) {
            $query->limit($limit);
        }

        if ($offset) {
            $query->offset($offset);
        }

        return $query->get();
    }
}

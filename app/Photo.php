<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'path',
        'filename',
        'original_name',
        'title',
        'description'
    ];

    protected $appends = [
        'thumb_url',
        'path_abs'
    ];

    public static $thumb_size = 150;

    public function getThumbUrlAttribute() {
        return dirname($this->attributes['path']).'/thumb_'.self::$thumb_size.'_'.basename($this->attributes['path']);
    }
    public function getPathAbsAttribute() {
        return url($this->attributes['path']);
    }
}

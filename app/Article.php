<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function photos() {
        return $this->belongsToMany('App\Photo', 'article_photos')->withPivot('is_cover');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blogcats extends Model
{
   protected $fillable = [
        'title',
        'slug',
        'tb-order',
        'meta_title',
        'meta_description',
        'details',
        'meta_tags',
        'og_image',
    ];
}

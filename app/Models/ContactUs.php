<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_tags',
        'user_type',
    ];
}

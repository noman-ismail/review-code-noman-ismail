<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Privacy extends Model
{
	
    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_tags',
		'title', 
        'content',
        'views',
        'microdata',
        'og_image'
    ];
}

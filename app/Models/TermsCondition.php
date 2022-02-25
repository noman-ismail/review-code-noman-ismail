<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class TermsCondition extends Model

{

    protected $fillable = [

        'meta_title',

        'meta_descp',

        'meta_tags',

		'title', 
		
		'microdata', 

        'content'

    ];

}


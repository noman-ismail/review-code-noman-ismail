<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
	protected $table = "api";
	protected $fillable = [
	'id',
	'name',
	'designaiton',
	'type',
	'pay',
	'scale',
	'appointment',
	'retirement',
	'birth',
	'non_fq'
	];
}
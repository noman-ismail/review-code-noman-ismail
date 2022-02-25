<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Contactuser extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
		'content',
        'subject',
        'type'
    ];
}
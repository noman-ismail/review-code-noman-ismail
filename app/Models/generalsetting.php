<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class generalsetting extends Model
{
    protected $fillable = [
        'logo',
        'favicon',
        'og',
        'google_analytics',
        'web_master',
        'host_name',
        'host_username',
        'host_password',
        'bing_master'
    ];
}

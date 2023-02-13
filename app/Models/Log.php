<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'request_method', 'request_url', 'response_code', 'response_body', 'request_time'
    ];
}

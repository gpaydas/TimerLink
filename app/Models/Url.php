<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Url extends Model
{
    protected $table='url';
    protected $fillable = [
    'ipadress',
    'long_link',
    'short_link',
    'start_date',
    'end_date',
    'period',
    'period_type'
    ];
    protected $guard=['id'];
}

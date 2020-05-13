<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlClick extends Model
{
    protected $table='urlclick';
    protected $fillable = [
    'ipadress',
    'url_id'
    ];
    protected $guard=['id'];
}

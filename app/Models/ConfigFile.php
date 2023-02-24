<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigFile extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =['title'];

    public function image(){

        return $this->morphOne('App\Models\Image', 'imageable');
    }
    
}

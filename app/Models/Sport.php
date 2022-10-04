<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    public function positions()
    {
       // return $this->hasMany(SportPosition::class);
        return $this->hasMany(SportPosition::class)->where('status','=', 1);
    }

}

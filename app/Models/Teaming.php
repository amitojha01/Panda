<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teaming extends Model
{
    use HasFactory;
    protected $table = "teamingup_group";  

   /*public function groupUser()
    {
        return $this->hasMany(TeamingGroupUser::class);
    }*/ 

}

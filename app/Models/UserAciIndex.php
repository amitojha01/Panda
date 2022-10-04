<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAciIndex extends Model
{
    use HasFactory;

    protected $table= 'user_aci_indexs';

    protected $fillable = [
        'user_id',
        'strength_aci',
        'speed_aci',
        'explosivness_aci',
        'agility_aci',
        'endurance_aci',
        'aci_index',
    ];
}

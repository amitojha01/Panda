<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPhysicalInformation extends Model
{

    protected $table = "user_physical_informations";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'height_feet',
        'height_inch',
        'weight',
        'wingspan_feet',
        'wingspan_inch',
        'head',
        'education_id',
        'grade',
        'dominant_hand',
        'dominant_foot'
    ];
}

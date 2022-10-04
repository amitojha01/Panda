<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkoutLibrary extends Model
{
    use HasFactory;
    protected $table = "user_workout_librarys";

    protected $fillable = [
        'workout_id',
        'workout_library_id',
        'user_id',
        'status'
    ];

}

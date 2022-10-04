<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkoutExercises extends Model
{
    use HasFactory;
     protected $table = "user_workout_exercises";

     protected $fillable = [
        'record_date',
        'video',
        'unit_1',
        'unit_2',
        'user_id',
        'workout_library_id',
        'category_id',
        'workout_category_librarys_id'
    ];

}

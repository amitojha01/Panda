<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutLibrary extends Model
{
    use HasFactory;
    protected $table = "workout_library";

    /**
     * Return measurement data
    */
    public function measurement()
    {
        return $this->belongsTo(WorkoutLibraryMeasurement::class);
    }
    /**
     * Return measurement data
    */
    public function userExcerise()
    {
        return $this->hasOne(UserWorkoutExercises::class);
    }
}

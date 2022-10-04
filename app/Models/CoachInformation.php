<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachInformation extends Model
{
    use HasFactory;

    protected $table = 'coach_informations';

    protected $fillable = ['coaching_level', 'sport_id', 'school', 'college_id','coach_level_name','club_name',
    'gender_of_coaching', 'about', 'about_link', 'preference_id', 'serve_as_reference', 'user_id', 'coaching_sport','sport_level', 'team_name','number_of_years', 'primary_age_group'];
}

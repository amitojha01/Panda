<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianInformation extends Model
{
    use HasFactory;

    protected $table= 'guardian_informations';

    protected $fillable = [
        'relationship',
        'first_name', 
        'last_name', 
        'enable_textmessage',
        'primary_phone',
        'primary_phone_type', 
        'is_primary_text',
        'secondary_phone',
        'secondary_phone_type', 
        'is_secondary_text', 
        'primary_email',
        'user_id'
    ];
}

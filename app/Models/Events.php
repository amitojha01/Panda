<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = "events";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category', 
        'event_name', 
        'location', 
        'city', 
        'state', 
        'start_date', 
        'end_date', 
        'even_note', 
        'even_details'
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state');
    }
}

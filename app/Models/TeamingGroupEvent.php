<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamingGroupEvent extends Model
{
    protected $table = "teaming_group_event";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'start', 
        'end', 
        
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state');
    }
}

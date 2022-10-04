<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageChat extends Model
{
    protected $table = "connection_message";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   	

    public function state()
    {
        return $this->belongsTo(State::class, 'state');
    }


}

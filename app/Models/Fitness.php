<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitness extends Model
{
    use HasFactory;
    protected $table="fitness";

    /**
     * Get the page associated with the banner.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}

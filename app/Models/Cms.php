<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;
    protected $table = "cms";

    /**
     * The attributes that are mass.
     *
     * @var array
     */
    protected $fillable = ['page_slug', 'content', 'image', 'status'];

    
    /**
     * Get the page associated with the banner.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}

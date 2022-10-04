<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialReview extends Model
{
    use HasFactory;
    protected $table = "testimonial_review";

    /**
     * Get the page associated with the banner.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}

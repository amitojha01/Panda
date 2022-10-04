<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompareGroup extends Model
{
    use HasFactory;
    protected $table="compare_group";

    /**
     * Get the page associated with the banner.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}

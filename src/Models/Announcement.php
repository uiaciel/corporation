<?php

namespace Uiaciel\Corporation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'category',
        'content',
        'image',
        'pdf',
        'homepage',
        'datepublish',
        'status'
    ];

    public function getPathImageAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('assets/images/default.jpg');
    }
}

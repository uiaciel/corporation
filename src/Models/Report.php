<?php

namespace Uiaciel\Corporation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
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
        'datepublish',
        'status',
        'hit',
    ];
}

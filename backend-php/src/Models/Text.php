<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = 'texts';

    public $timestamps = false;

    protected $fillable = [
        'author_id',
        'title',
        'body',
        'description',
        'role',
        'cover_image',
        'visibility',
    ];
}

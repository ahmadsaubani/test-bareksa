<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

/**
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $uuid
 */
class Tag extends Model
{
    use CreateUuid;

    protected $fillable = [
        'slug',
        'title'
    ];
}

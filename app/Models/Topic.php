<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

/**
 * @property mixed $uuid
 * @property mixed $title
 * @property mixed $slug
 */
class Topic extends Model
{
    use CreateUuid;

    protected $fillable = [
        'slug',
        'title'
    ];
}

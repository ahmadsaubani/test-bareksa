<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

class Topic extends Model
{
    use CreateUuid;

    protected $fillable = [
        'slug',
        'title'
    ];
}

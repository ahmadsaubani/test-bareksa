<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

class News extends Model
{
    use CreateUuid;

    protected $fillable = [
        "slug",
        "title",
        "description",
        "status"
    ];
}

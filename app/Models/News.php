<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

/**
 * @method static updateOrCreate(array $array, array $array1)
 */
class News extends Model
{
    use CreateUuid;

    const STATUS_DRAFT      = "draft";
    const STATUS_DELETED    = "deleted";
    const STATUS_PUBLISHED  = "publish";

    protected $fillable = [
        "slug",
        "topic_id",
        "title",
        "description",
        "status"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $uuid
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $description
 *
 * @method static updateOrCreate(array $array, array $array1)
 */
class News extends Model
{
    use CreateUuid, SoftDeletes;

    const STATUS_DRAFT      = "draft";
    const STATUS_PUBLISHED  = "publish";
    const STATUS_DELETED    = "deleted";


    protected $fillable = [
        "slug",
        "topic_id",
        "title",
        "description",
        "status"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

class NewsReference extends Model
{
    use CreateUuid;

    protected $fillable = [
        'ref_id',
        'ref_model',
        'ref_class',
        'tag_id'
    ];
}

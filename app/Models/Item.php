<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

class Item extends Model
{
    use CreateUuid;
    
    protected $fillable = [
        'type_id',
        'description',
        'price',
    ];
}

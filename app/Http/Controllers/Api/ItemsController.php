<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Transformers\TagTransformer;

class ItemsController extends Controller
{
    public function populate()
    {
//        $types = Item::get();
//
//        $result = $this->collection($types, new TagTransformer(), "item_type");
//
//        return $this->showResultV2('Data Found', $result);
    }
}

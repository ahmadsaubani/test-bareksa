<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\ApiResponser;
use App\Traits\TransformData;
use App\Exceptions\CustomMessagesException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponser, TransformData;

    /**
     * @param Illuminate\Database\Eloquent\Model $model
     * @param Uuid $uuid
     * @param String $note
     */
    public function getId($model, $uuid, $note)
    {
        $data = $model::where("uuid", $uuid)->first();

        if (!$data) {
            throw new Exception($note. " tidak ditemukan pada uuid " . $uuid, 403);
        }
        
        return $data->id;
    }
    public function search($search, $model, $indexSearch) {

        $model->where($indexSearch, "LIKE", "%" . $search ."%");

        return $model;
    }
}

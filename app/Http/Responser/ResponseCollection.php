<?php

namespace App\Http\Responser;

use Illuminate\Database\Eloquent\Builder;

final class ResponseCollection extends AbstractResponse
{
    public function __construct($pageSize = 1000)
    {
        parent::__construct(null, $pageSize);
    }


    public function render(Builder $qb)
    {
        $data    = $qb->paginate($this->perPage);
        return collect($data->items());
    }
}

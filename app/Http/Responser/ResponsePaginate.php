<?php

namespace App\Http\Responser;

use Illuminate\Database\Eloquent\Builder;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

final class ResponsePaginate extends AbstractResponse
{
    protected $transformer = null;
    private $include     = true;

    public function __construct(TransformerAbstract $transformer, $include = "", $perPage = 10)
    {
        $this->transformer = $transformer;
        $this->include     = $include;

        parent::__construct($transformer, $perPage);
    }

    public function render(Builder $qb)
    {
        $manager = $this->getFractalManager();
        $data    = $qb->paginate($this->perPage);

        $resource = new Collection($data, $this->transformer, $this->transformer->type);
        $resource->setPaginator(new IlluminatePaginatorAdapter($data));

        if ($this->include) {
            $manager->parseIncludes($this->include);
        }
        return $manager->createData($resource)->toArray();
    }
}

<?php

namespace App\Http\Responser;

use App\Serializers\TransformerJsonApiSerializer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;

abstract class AbstractResponse
{
    protected $perPage;
    protected $transformer;

    public function __construct(?TransformerAbstract $transformer = null, $perPage = null)
    {
        $this->perPage     = (int)$perPage ? $perPage : 10;
        $this->transformer = $transformer;

        $this->generatePageAndSize();
    }

    protected function getFractalManager()
    {
        $request = app(Request::class);
        $manager = new Manager();
        $manager->setSerializer(new TransformerJsonApiSerializer());
        if (!empty($request->query('include'))) {
            $manager->parseIncludes($request->query('include'));
        }
        return $manager;
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    abstract public function render(Builder $query);


    protected function generatePageAndSize()
    {
        $perPage       = $this->perPage;
        $this->perPage = (int)$perPage ? (int)$perPage : 1000;
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateTagRequest;
use App\Repositories\TagsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\TagTransformer;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * @var TagsRepository
     */
    protected $tagRepository;

    /**
     * @param TagsRepository $tagRepository
     */
    public function __construct(TagsRepository $tagRepository) {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param CreateTagRequest $request
     * @return JsonResponse
     */
    public function createTag(CreateTagRequest $request): JsonResponse
    {
        $request->validated();

        $data  = [];
        $data["title"] = $request->title;
        $data["slug"]  = Str::slug($request->title);

        $result = $this->item($this->tagRepository->create($data) , new TagTransformer());

        return $this->showResultV2('Data Found', $result);
    }
}

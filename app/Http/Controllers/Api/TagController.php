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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAllTags(Request $request): JsonResponse
    {
        $result = $this->collection($this->tagRepository->get() , new TagTransformer());

        return $this->showResultV2('Data Found', $result, 200);
    }

    /**
     * @param CreateTagRequest $request
     * @return JsonResponse
     */
    public function createTag(CreateTagRequest $request): JsonResponse
    {
        $request->validated();

        $input          = $request->only("title");
        $input["slug"]  = Str::slug($request->title);

        $result = $this->item($this->tagRepository->create($input) , new TagTransformer());

        return $this->showResultV2('Data Created', $result, 201);
    }

    /**
     * @throws \Exception
     */
    public function updateTagByUuid(CreateTagRequest $request, $uuidTag): JsonResponse
    {
        $request->validated();

        $input          = $request->only("title");
        $input["slug"]  = Str::slug($request->title);

        try {
            $tag = $this->tagRepository->getTagByUuid($uuidTag);

            $result = $this->item($this->tagRepository->updateById($tag->id, $input) , new TagTransformer());

            return $this->showResultV2('Data updated', $result, 200);
        } catch (\Exception $exception) {
            return $this->realErrorResponse($exception);
        }
    }

    /**
     * @param $uuidTag
     *
     * @return JsonResponse
     */
    public function deleteTagByUuid($uuidTag): JsonResponse
    {
        try {
            $tag = $this->tagRepository->getTagByUuid($uuidTag);

            $this->tagRepository->deleteById($tag->id);

            return $this->showResult('Data deleted', [], 200);
        } catch (\Exception $exception) {
            return $this->realErrorResponse($exception);
        }
    }
}

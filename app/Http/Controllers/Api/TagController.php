<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateTagRequest;
use App\Repositories\TagsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\TagTransformer;
use Illuminate\Support\Facades\DB;
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
     * @throws \Throwable
     */
    public function createTag(CreateTagRequest $request): JsonResponse
    {
        $request->validated();

        $input          = $request->only("title");
        $input["slug"]  = Str::slug($request->title);
        try {
            DB::beginTransaction();
            $tag    = $this->tagRepository->create($input);

            $result = $this->item($tag, new TagTransformer());
            DB::commit();

            return $this->showResultV2('Data Created', $result, 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->realErrorResponse($exception);
        }


    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function updateTagByUuid(CreateTagRequest $request, $uuidTag): JsonResponse
    {
        $request->validated();

        $input          = $request->only("title");
        $input["slug"]  = Str::slug($request->title);

        try {
            DB::beginTransaction();
            $tag        = $this->tagRepository->getTagByUuid($uuidTag);
            $updateTag  = $this->tagRepository->updateById($tag->id, $input);

            $result = $this->item($updateTag, new TagTransformer());
            DB::commit();

            return $this->showResultV2('Data updated', $result, 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->realErrorResponse($exception);
        }
    }

    /**
     * @param $uuidTag
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteTagByUuid($uuidTag): JsonResponse
    {
        try {
            DB::beginTransaction();
            $tag = $this->tagRepository->getTagByUuid($uuidTag);

            $this->tagRepository->deleteById($tag->id);
            DB::commit();

            return $this->showResult('Data deleted', [], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->realErrorResponse($exception);
        }
    }
}

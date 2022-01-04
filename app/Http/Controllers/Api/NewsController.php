<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Repositories\NewsRepository;
use App\Transformers\NewsTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * @var NewsRepository
     */
    protected $newsRepository;

    /**
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository) {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAllNews(Request $request): JsonResponse
    {
        try {
            $news  = $this->newsRepository->filter($request->all());

            $data  = $news->get();

            $result = $this->collection($data, new NewsTransformer(), 'topic,tags');

            return $this->showResultV2('Data Found', $result, 200);
        } catch (\Exception $exception) {
            return $this->realErrorResponse($exception);
        }

    }

    /**
     * @param CreateNewsRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateNewsRequest $request): JsonResponse
    {
        $request->validated();

        $input = $request->only("title", "description", "tag_id", "topic_id");

        $input["slug"] = Str::slug($input["title"]);

        try {
            DB::beginTransaction();

            $news = $this->newsRepository->createNews($input);
            $result = $this->item($news, new NewsTransformer(), 'topic,tags');

            DB::commit();
            return $this->showResultV2('Data Created', $result, 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->realErrorResponse($exception);
        }
    }

    /**
     * @param UpdateNewsRequest $request
     * @param $uuidNews
     *
     * @return JsonResponse
     */
    public function updateNewsByUuid(UpdateNewsRequest $request, $uuidNews): JsonResponse
    {
        $request->validated();

        $input = $request->only("title", "description", "tag_id", "topic_id");

        $input["slug"] = Str::slug($input["title"]);

        try {
            DB::beginTransaction();
            $news = $this->newsRepository->getNewsByUuid($uuidNews);

            $test = $this->newsRepository->updateNews($news, $input);

            $result = $this->item($test, new NewsTransformer(), 'topic,tags');

            DB::commit();
            return $this->showResultV2('Data Found', $result, 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->realErrorResponse($exception);
        }
    }

    /**
     * @param $uuidNews
     *
     * @return JsonResponse
     */
    public function deleteNewsByUuid($uuidNews): JsonResponse
    {
        try {
            $this->newsRepository->updateStatusNewsToDeleted($uuidNews);

            return $this->showResult('Data deleted', [], 200);
        } catch (\Exception $exception) {
            return $this->realErrorResponse($exception);
        }
    }
}

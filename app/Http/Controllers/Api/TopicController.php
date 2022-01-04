<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateOrUpdateTopicRequest;
use App\Repositories\TopicRepository;
use App\Transformers\TopicTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * @var TopicRepository
     */
    protected $topicRepository;

    /**
     * @param TopicRepository $topicRepository
     */
    public function __construct(TopicRepository $topicRepository) {
        $this->topicRepository = $topicRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAllTopics(Request $request): JsonResponse
    {
        $result = $this->collection($this->topicRepository->get() , new TopicTransformer());

        return $this->showResultV2('Data Found', $result, 200);
    }

    /**
     * @param CreateOrUpdateTopicRequest $request
     * @return JsonResponse
     */
    public function createTopic(CreateOrUpdateTopicRequest $request): JsonResponse
    {
        $request->validated();

        $input          = $request->only("title");
        $input["slug"]  = Str::slug($request->title);

        $result = $this->item($this->topicRepository->create($input) , new TopicTransformer());

        return $this->showResultV2('Data Created', $result, 201);
    }

    /**
     * @throws \Exception
     */
    public function updateTopicByUuid(CreateOrUpdateTopicRequest $request, $uuidTopic): JsonResponse
    {
        $request->validated();
        $input          = $request->only("title");
        $input["slug"]  = Str::slug($request->title);

        try {
            $topic = $this->topicRepository->getTopicByUuid($uuidTopic);

            $result = $this->item($this->topicRepository->updateById($topic->id, $input) , new TopicTransformer());

            return $this->showResultV2('Data updated', $result, 200);
        } catch (\Exception $exception) {
            return $this->realErrorResponse($exception);
        }
    }

    /**
     * @param $uuidTopic
     *
     * @return JsonResponse
     */
    public function deleteTopicByUuid($uuidTopic): JsonResponse
    {
        try {
            $topic = $this->topicRepository->getTopicByUuid($uuidTopic);

            $this->topicRepository->deleteById($topic->id);

            return $this->showResult('Data deleted', [], 200);
        } catch (\Exception $exception) {
            return $this->realErrorResponse($exception);
        }
    }
}

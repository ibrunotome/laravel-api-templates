<?php

namespace Preferred\Interfaces\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

trait ResponseTrait
{
    /**
     * The current path of resource to respond
     *
     * @var string
     */
    protected $resourceItem;

    /**
     * The current path of collection resource to respond
     *
     * @var string
     */
    protected $resourceCollection;

    public function respondWithCustomData($data, $status = 200)
    {
        return new JsonResponse([
            'data' => $data,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()]
        ], $status);
    }

    protected function getTimestampInMilliseconds()
    {
        return (int)bcdiv(now()->format('Uu'), 1000, 0);
    }

    /**
     * Return no content for delete requests (status 204)
     *
     * @return JsonResponse
     */
    public function respondWithNoContent()
    {
        return new JsonResponse([
            'data' => null,
            'meta' => ['timestamp' => $this->getTimestampInMilliseconds()]
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return collection response from the application
     *
     * @param Collection $collection
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithCollection($collection)
    {
        return (new $this->resourceCollection($collection))->additional(
            ['meta' => ['timestamp' => $this->getTimestampInMilliseconds()]]
        );
    }

    /**
     * Return single item response from the application
     *
     * @param Model $item
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithItem($item)
    {
        return (new $this->resourceItem($item))->additional(
            ['meta' => ['timestamp' => $this->getTimestampInMilliseconds()]]
        );
    }
}

<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;

abstract class Base implements Responsable
{
    public function __construct(
        protected mixed $data = [],
        public int $statusCode = Response::HTTP_OK
    ) {
    }

    /** @inheritDoc */
    public function toResponse($request): Response
    {
        return response()->json($this->makeResponseData(), $this->statusCode);
    }

    /**
     * Prepare data to array
     *
     * @return array
     */
    protected function prepareData(): array
    {
        if ($this->data instanceof Arrayable) {
            return $this->data->toArray();
        }

        return $this->data;
    }

    /**
     * Create response body
     *
     * @return array|null
     */
    abstract protected function makeResponseData(): ?array;
}

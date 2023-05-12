<?php

namespace App\Http\Responses;

use Illuminate\Pagination\LengthAwarePaginator;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;

class Success extends Base
{
    /**
     * @param mixed $data
     * @param int $code
     */
    #[Pure]
    public function __construct(mixed $data, int $code = Response::HTTP_OK)
    {
        parent::__construct($data, $code);
    }

    /**
     * Create HTTP Response with pagination
     *
     * @param $request
     * @param LengthAwarePaginator $paginator
     *
     * @return Response
     */
    public function toResponseWithPagination($request, LengthAwarePaginator $paginator): Response
    {
        return response()->json($this->makeResponseDataWithPagination($paginator), $this->statusCode);
    }

    /**
     * Prepare pagination data
     *
     * @param LengthAwarePaginator $paginator
     *
     * @return array
     */
    private function makeResponseDataWithPagination(LengthAwarePaginator $paginator): array
    {
        return [
            'data' => $this->prepareData(),
            'current_page' => $paginator->currentPage(),
            'first_page_url' => $paginator->url(1),
            'next_page_url' => $paginator->nextPageUrl(),
            'prev_page_url' => $paginator->previousPageUrl(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
        ];
    }

    /** @inheritdoc */
    #[ArrayShape(['data' => "array"])]
    protected function makeResponseData(): array
    {
        return [
            'data' => $this->prepareData(),
        ];
    }
}

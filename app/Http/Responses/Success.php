<?php

namespace App\Http\Responses;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;

class Success extends Base
{
    /** @param $data */
    #[Pure]
    public function __construct($data, int $code = Response::HTTP_OK)
    {
        parent::__construct($data, $code);
    }

    /** @inheritdoc */
    #[ArrayShape(['data' => "array"])]
    protected function makeResponseData(): ?array
    {
        return [
            'data' => $this->prepareData()
        ];
    }
}

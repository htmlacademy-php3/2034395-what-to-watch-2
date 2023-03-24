<?php

namespace App\Http\Responses;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;

class Fail extends Base
{
    public int $statusCode = Response::HTTP_BAD_REQUEST;

    /**
     * @param $data
     * @param string|null $message
     * @param int $code
     */
    #[Pure]
    public function __construct($data, protected ?string $message = null, int $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($data, $code);
    }

    /** @inheritdoc */
    #[ArrayShape(['message' => "null|string", 'errors' => "array"])]
    protected function makeResponseData(): ?array
    {
        return [
            'message' => $this->message,
            'errors' => $this->prepareData(),
        ];
    }
}

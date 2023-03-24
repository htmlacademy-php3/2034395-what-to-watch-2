<?php

namespace App\Http\Responses;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Success extends Base
{
    /** @param $data */
    #[Pure]
    public function __construct($data)
    {
        parent::__construct($data);
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

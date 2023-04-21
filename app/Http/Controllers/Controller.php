<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    /**
     * @param Request $request
     *
     * @return array
     *
     * @throws LogicException
     */
    public function getPostData(Request $request): array
    {
        $post = $request->getContent();

        if (empty($post)) {
            throw new LogicException('No request data', Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($post, true);

        if (!$data) {
            throw new LogicException('Can not decode request body', Response::HTTP_BAD_REQUEST);
        }

        return $data;
    }
}

<?php

namespace App\Models;

use LogicException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Checker
{
    private array $params = [
        NotFoundHttpException::class => ['Not Found', null, Response::HTTP_NOT_FOUND],
        BadRequestHttpException::class => ['Bad Request', null, Response::HTTP_BAD_REQUEST],
        AccessDeniedHttpException::class => ['Forbidden', null, Response::HTTP_FORBIDDEN],
        LogicException::class => ['Action Error', Response::HTTP_CONFLICT]
    ];

    /**
     * @param bool $condition
     * @param string $throwable
     *
     * @return void
     *
     * @throws Throwable
     */
    public function check(bool $condition, string $throwable): void
    {
        throw_if($condition, new $throwable(...$this->params[$throwable]));
    }
}

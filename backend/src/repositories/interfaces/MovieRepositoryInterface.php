<?php

namespace Mentalaffect\WhatToWatch\repositories\interfaces;

interface MovieRepositoryInterface
{
    public function all(): array;

    public function getById(string $id): array;
}
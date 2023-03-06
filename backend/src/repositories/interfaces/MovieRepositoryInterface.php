<?php

namespace Mentalaffect\WhatToWatch\repositories\interfaces;

interface MovieRepositoryInterface
{
    public function getById(string $id): array;
}

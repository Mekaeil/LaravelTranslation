<?php

namespace Mekaeil\LaravelTranslation\Repository\Contracts;

interface RepositoryInterface
{

    public function find(int $ID);

    public function store(array $item);

    public function update(int $ID, array $item);

    public function all(array $columns , array $relations , int $perPage , array $condition);

}
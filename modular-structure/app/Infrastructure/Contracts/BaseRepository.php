<?php

namespace App\Infrastructure\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface BaseRepository
{
    /**
     * Set the relationships of the query.
     *
     * @param array $with
     * @return BaseRepository
     */
    public function with(array $with = []): BaseRepository;

    /**
     * Set withoutGlobalScopes attribute to true and apply it to the query.
     *
     * @return BaseRepository
     */
    public function withoutGlobalScopes(): BaseRepository;

    /**
     * Find a resource by id.
     *
     * @param string $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findOneById(string $id): Model;

    /**
     * Find a resource by key value criteria.
     *
     * @param array $criteria
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findOneBy(array $criteria): Model;

    /**
     * Search All resources by spatie query builder.
     *
     * @return LengthAwarePaginator
     */
    public function findByFilters(): LengthAwarePaginator;

    /**
     * Save a resource.
     *
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model;

    /**
     * Update a resource.
     *
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function update(Model $model, array $data): Model;
}

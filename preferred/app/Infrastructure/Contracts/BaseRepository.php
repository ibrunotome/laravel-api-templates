<?php

namespace Preferred\Infrastructure\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface BaseRepository
{
    /**
     * Set the relationships of the query
     *
     * @param array $with
     *
     * @return mixed
     */
    public function with(array $with = []);

    /**
     * Set withoutGlobalScopes attribute to true and apply it to the query
     *
     * @return mixed
     */
    public function withoutGlobalScopes();

    /**
     * Find a resource by id
     *
     * @param string $id
     *
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    public function findOneById($id);

    /**
     * Find a resource by criteria
     *
     * @param array $criteria
     *
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    public function findOneByCriteria(array $criteria);

    /**
     * Search All resources by criteria
     *
     * @param array $criteria
     *
     * @return Collection
     */
    public function findByCriteria(array $criteria = []): Collection;

    /**
     * Search All resources by spatie query builder
     *
     * @return Collection
     */
    public function findByFilters();

    /**
     * Save a resource
     *
     * @param array $data
     *
     * @return Model
     */
    public function store(array $data);

    /**
     * Update a resource
     *
     * @param Model $model
     * @param array $data
     *
     * @return Model
     */
    public function update(Model $model, array $data);
}

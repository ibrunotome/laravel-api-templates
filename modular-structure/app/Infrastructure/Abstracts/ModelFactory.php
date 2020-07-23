<?php

namespace App\Infrastructure\Abstracts;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/**
 * Class ModelFactory.
 * Base Factory for usage inside domains.
 */
abstract class ModelFactory
{
    protected Factory $factory;

    protected string $model;

    protected Generator $faker;

    /**
     * BaseFactory constructor.
     */
    public function __construct()
    {
        $this->factory = app()->make(Factory::class);
        $this->faker = app()->make(Generator::class);
    }

    public function define()
    {
        $this->states();

        $this->factory->define($this->model, function () {
            return $this->fields();
        });
    }

    abstract public function states();

    /**
     * @return array
     * @throws \Exception
     */
    abstract public function fields();
}

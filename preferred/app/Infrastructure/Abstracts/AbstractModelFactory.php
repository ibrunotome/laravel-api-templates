<?php

namespace Preferred\Infrastructure\Abstracts;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/**
 * Class ModelFactory.
 *
 * Base Factory for usage inside domains.
 */
abstract class AbstractModelFactory
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

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

    abstract public function fields();
}

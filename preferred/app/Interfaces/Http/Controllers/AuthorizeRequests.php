<?php

namespace Preferred\Interfaces\Http\Controllers;

use Illuminate\Contracts\Auth\Access\Gate;

trait AuthorizeRequests
{
    public function callAction($method, $parameters)
    {
        if ($ability = $this->getAbility($method)) {
            $this->authorize($ability);
        }

        return parent::callAction($method, $parameters);
    }

    private function getAbility($method)
    {
        $route = request()->route()->getName();
        $route = str_replace('-', '_', $route);
        $routeName = explode('.', $route);
        $action = array_get($this->resourceAbilityMap(), $method);

        return $action ? $action . '_' . $routeName[1] : null;
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'index'   => 'list',
            'show'    => 'view',
            'update'  => 'update',
            'store'   => 'create',
            'destroy' => 'delete',
        ];
    }

    /**
     * Authorize a given action for the current user.
     *
     * @param  mixed       $ability
     * @param  mixed|array $arguments
     *
     * @return \Illuminate\Auth\Access\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorize($ability, $arguments = [])
    {
        [$ability, $arguments] = $this->parseAbilityAndArguments($ability, $arguments);

        return app(Gate::class)->authorize($ability, $arguments);
    }

    /**
     * Guesses the ability's name if it wasn't provided.
     *
     * @param  mixed       $ability
     * @param  mixed|array $arguments
     *
     * @return array
     */
    protected function parseAbilityAndArguments($ability, $arguments)
    {
        if (is_string($ability) && strpos($ability, '\\') === false) {
            return [$ability, $arguments];
        }

        $method = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'];

        return [$this->normalizeGuessedAbilityName($method), $ability];
    }

    /**
     * Normalize the ability name that has been guessed from the method name.
     *
     * @param  string $ability
     *
     * @return string
     */
    protected function normalizeGuessedAbilityName($ability)
    {
        $map = $this->resourceAbilityMap();

        return $map[$ability] ?? $ability;
    }
}

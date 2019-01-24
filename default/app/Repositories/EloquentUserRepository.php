<?php

namespace App\Repositories;

use App\Contracts\UserRepository;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

class EloquentUserRepository extends AbstractEloquentRepository implements UserRepository
{
    private $defaultSort = '-created_at';

    private $defaultSelect = [
        'id',
        'email',
        'is_active',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    private $allowedFilters = [
        'is_active',
    ];

    private $allowedSorts = [
        'updated_at',
        'created_at',
    ];

    private $allowedIncludes = [
        'profile',
        'authorizeddevices',
        'loginhistories',
    ];

    public function findByFilters()
    {
        $perPage = (int)request()->get('limit');
        $perPage = $perPage >= 1 && $perPage <= 100 ? $perPage : 20;

        return QueryBuilder::for(User::class)
            ->select($this->defaultSelect)
            ->allowedFilters($this->allowedFilters)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts($this->allowedSorts)
            ->defaultSort($this->defaultSort)
            ->paginate($perPage);
    }

    public function update(Model $model, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);

            event(new PasswordReset($model));
        }

        return parent::update($model, $data);
    }
}

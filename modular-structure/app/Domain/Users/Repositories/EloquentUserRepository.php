<?php

namespace App\Domain\Users\Repositories;

use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Entities\User;
use App\Infrastructure\Abstracts\EloquentRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Spatie\QueryBuilder\QueryBuilder;

class EloquentUserRepository extends EloquentRepository implements UserRepository
{
    private string $defaultSort = '-created_at';

    private array $defaultSelect = [
        'id',
        'email',
        'is_active',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    private array $allowedFilters = [
        'is_active',
    ];

    private array $allowedSorts = [
        'updated_at',
        'created_at',
    ];

    private array $allowedIncludes = [
        'profile',
        'authorizeddevices',
        'loginhistories',
        'notifications',
        'unreadnotifications',
    ];

    public function findByFilters(): LengthAwarePaginator
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

    public function update(Model $model, array $data): Model
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);

            event(new PasswordReset(auth()->user()));
        }

        return parent::update($model, $data);
    }

    public function setNewEmailTokenConfirmation($userId)
    {
        $this->withoutGlobalScopes()
            ->findOneById($userId)
            ->update([
                'email_token_confirmation' => Uuid::uuid4()->toString(),
            ]);
    }
}

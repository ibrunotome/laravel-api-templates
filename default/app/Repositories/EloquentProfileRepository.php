<?php

namespace App\Repositories;

use App\Contracts\ProfileRepository;
use App\Models\Profile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Ramsey\Uuid\Uuid;
use Spatie\QueryBuilder\QueryBuilder;

class EloquentProfileRepository extends EloquentRepository implements ProfileRepository
{
    private string $defaultSort = '-created_at';

    private array $defaultSelect = [
        'name',
        'google2fa_enable',
        'created_at',
        'updated_at',
    ];

    private array $allowedFilters = [
        'google2fa_enable',
    ];

    private array $allowedSorts = [
        'updated_at',
        'created_at',
    ];

    public function findByFilters(): LengthAwarePaginator
    {
        $perPage = (int)request()->get('limit');
        $perPage = $perPage >= 1 && $perPage <= 100 ? $perPage : 20;

        return QueryBuilder::for(Profile::class)
            ->select($this->defaultSelect)
            ->allowedFilters($this->allowedFilters)
            ->allowedSorts($this->allowedSorts)
            ->defaultSort($this->defaultSort)
            ->paginate($perPage);
    }

    public function setNewEmailTokenConfirmation($userId)
    {
        $this->withoutGlobalScopes()
            ->findOneBy(['user_id' => $userId])
            ->update([
                'email_token_confirmation' => Uuid::uuid4(),
            ]);
    }
}

<?php

namespace Preferred\Domain\Users\Repositories;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\Model;
use Preferred\Domain\Users\Contracts\UserRepository;
use Preferred\Infrastructure\Abstracts\AbstractEloquentRepository;

class EloquentUserRepository extends AbstractEloquentRepository implements UserRepository
{
    public function update(Model $model, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);

            event(new PasswordReset($model));
        }

        return parent::update($model, $data);
    }
}

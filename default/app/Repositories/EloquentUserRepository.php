<?php

namespace App\Repositories;

use App\Contracts\UserRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\Model;

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

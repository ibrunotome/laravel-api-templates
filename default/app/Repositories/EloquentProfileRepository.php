<?php

namespace App\Repositories;

use App\Contracts\ProfileRepository;
use Ramsey\Uuid\Uuid;

class EloquentProfileRepository extends AbstractEloquentRepository implements ProfileRepository
{
    public function setNewEmailTokenConfirmation($userId)
    {
        $this->withoutGlobalScopes()
            ->findOneBy(['user_id' => $userId])
            ->update([
                'email_token_confirmation' => Uuid::uuid4(),
            ]);
    }
}

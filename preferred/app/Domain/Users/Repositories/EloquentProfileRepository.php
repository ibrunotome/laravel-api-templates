<?php

namespace Preferred\Domain\Users\Repositories;

use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Infrastructure\Abstracts\AbstractEloquentRepository;
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

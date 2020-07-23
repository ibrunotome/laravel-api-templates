<?php

namespace App\Domain\Users\Contracts;

use App\Infrastructure\Contracts\BaseRepository;

interface UserRepository extends BaseRepository
{
    public function setNewEmailTokenConfirmation($userId);
}

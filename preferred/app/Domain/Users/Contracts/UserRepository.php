<?php

namespace Preferred\Domain\Users\Contracts;

use Preferred\Infrastructure\Contracts\BaseRepository;

interface UserRepository extends BaseRepository
{
    public function setNewEmailTokenConfirmation($userId);
}

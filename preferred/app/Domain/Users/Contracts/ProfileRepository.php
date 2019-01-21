<?php

namespace Preferred\Domain\Users\Contracts;

use Preferred\Infrastructure\Contracts\BaseRepository;

interface ProfileRepository extends BaseRepository
{
    public function setNewEmailTokenConfirmation($userId);
}

<?php

namespace App\Contracts;

interface ProfileRepository extends BaseRepository
{
    public function setNewEmailTokenConfirmation($userId);
}

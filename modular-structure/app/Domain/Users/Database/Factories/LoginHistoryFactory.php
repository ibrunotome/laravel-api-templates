<?php

namespace App\Domain\Users\Database\Factories;

use App\Domain\Users\Entities\LoginHistory;
use App\Infrastructure\Abstracts\ModelFactory;
use Ramsey\Uuid\Uuid;

class LoginHistoryFactory extends ModelFactory
{
    protected string $model = LoginHistory::class;

    public function fields()
    {
        return [
            'id' => Uuid::uuid4(),
        ];
    }

    public function states()
    {
    }
}

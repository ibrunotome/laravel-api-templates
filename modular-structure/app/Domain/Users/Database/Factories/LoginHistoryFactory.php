<?php

namespace Preferred\Domain\Users\Database\Factories;

use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Infrastructure\Abstracts\ModelFactory;
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

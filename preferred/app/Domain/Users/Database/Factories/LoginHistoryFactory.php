<?php

namespace Preferred\Domain\Users\Database\Factories;

use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Infrastructure\Abstracts\AbstractModelFactory;
use Ramsey\Uuid\Uuid;

class LoginHistoryFactory extends AbstractModelFactory
{
    protected $model = LoginHistory::class;

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

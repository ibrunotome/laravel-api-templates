<?php

namespace Preferred\Domain\Users\Database\Factories;

use Preferred\Domain\Users\Entities\Profile;
use Preferred\Infrastructure\Abstracts\ModelFactory;
use Ramsey\Uuid\Uuid;

class ProfileFactory extends ModelFactory
{
    protected $model = Profile::class;

    public function fields()
    {
        return [
            'id'                          => Uuid::uuid4(),
            'name'                        => $this->faker->name,
            'anti_phishing_code'          => $this->faker->word,
            'email_token_confirmation'    => Uuid::uuid4(),
            'email_token_disable_account' => Uuid::uuid4(),
        ];
    }

    public function states()
    {
    }
}

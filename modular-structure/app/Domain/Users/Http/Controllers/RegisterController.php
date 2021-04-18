<?php

namespace App\Domain\Users\Http\Controllers;

use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Entities\User;
use App\Domain\Users\Rules\WeakPasswordRule;
use App\Interfaces\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private UserRepository $userRepository)
    {
        $this->middleware('guest');
    }

    /**
     * The user has been registered.
     *
     * @param Request $request
     * @param User    $user
     * @return mixed
     */
    protected function registered(Request $request, User $user)
    {
        $this->guard()->logout();

        $message = __(
            'We sent a confirmation email to :email. Please follow the instructions to complete your registration.',
            ['email' => $user->email]
        );

        return $this->respondWithCustomData(['message' => $message], Response::HTTP_CREATED);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => [
                'required',
                'string',
                'max:255',
            ],
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                new WeakPasswordRule(),
            ],
            'locale'   => [
                'nullable',
                'string',
                'in:en_US,pt_BR',
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): Model
    {
        return $this->userRepository->store([
            'email'                       => $data['email'],
            'name'                        => $data['name'],
            'email_token_confirmation'    => Uuid::uuid4()->toString(),
            'email_token_disable_account' => Uuid::uuid4()->toString(),
            'password'                    => bcrypt($data['password']),
            'is_active'                   => 1,
            'email_verified_at'           => null,
            'locale'                      => $data['locale'] ?? 'pt_BR',
        ]);
    }
}

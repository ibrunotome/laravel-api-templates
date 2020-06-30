<?php
/**
 * Created by PhpStorm.
 * User: brunotome
 * Date: 26/05/19
 * Time: 16:16
 */

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FormValidationException extends \Illuminate\Validation\ValidationException
{
    public $validator;

    public $status = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * Create a new exception instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param string                                     $errorBag
     * @return void
     */
    public function __construct($validator, $response = null, $errorBag = 'default')
    {
        parent::__construct($validator);

        $this->response = $response;
        $this->errorBag = $errorBag;
        $this->validator = $validator;
    }

    public function render()
    {
        return new JsonResponse([
            'data' => [
                'message' => 'The given data was invalid.',
                'errors'  => $this->validator->errors()->messages(),
            ],
            'meta' => ['timestamp' => intdiv((int)now()->format('Uu'), 1000)],
        ], $this->status);
    }
}

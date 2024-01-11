<?php

namespace Root\MvcApi\Request;

use Swoole\Http\Request;

class CreateUserRequest implements AbstractRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function rules(): array
    {
        return [
            'email',
            'password',
            'name',
            'avatar'
        ];
    }

    public function validate(array $data, array $rules): bool

    {
        $validated = true;
        foreach ($rules as $rule) {
            if (!array_key_exists($rule, $data)) {
                $validated = false;
                break;
            }
        }
        return $validated;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}

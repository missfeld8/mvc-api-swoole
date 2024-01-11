<?php

namespace Root\MvcApi\Request;

use Swoole\Http\Request;

interface AbstractRequest
{
    public function rules(): array;

    public function validate(array $data, array $rules): bool;

    public function getRequest(): Request;
}

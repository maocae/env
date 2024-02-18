<?php

namespace Maocae\Env\Exceptions;

use RuntimeException;

class InvalidEnvFileContent extends RuntimeException
{
    protected $message = "Invalid environment file content !";
}
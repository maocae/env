<?php

namespace Maocae\Env\Exceptions;

use RuntimeException;

class EnvFileNotFoundException extends RuntimeException
{
    protected $message = "Environment file not found !";
}
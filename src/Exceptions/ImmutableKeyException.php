<?php

namespace Maocae\Env\Exceptions;

use RuntimeException;

class ImmutableKeyException extends RuntimeException
{
    protected $message = "Immutable environment key !";
}
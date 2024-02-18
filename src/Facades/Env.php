<?php

namespace Maocae\Env\Facades;

use Maocae\Env\Env as BaseClass;
use Maocae\Support\Patterns\Traits\CallStatically;

/**
 * @method static void setImmutable(bool $immutable = true)
 * @method static void setLocalOnly(bool $local_only = true)
 * @method static void setStoreInEnvironmentVariables(bool $store_in_env_variables = true)
 * @method static mixed getEnv(string $key, mixed $fallback = null)
 * @method static void setEnv(string $key, mixed $value = null)
 * @method static bool removeEnv(string $key)
 * @method static array getAll()
 */
class Env
{
    use CallStatically;

    protected static function getClassSubject(): string
    {
        return BaseClass::class;
    }
}
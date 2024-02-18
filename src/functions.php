<?php

use Maocae\Env\Facades\Env;


/**
 * Get environment data from given key, and return fallback if data presented
 *
 * @param string $key
 * @param mixed|null $fallback
 * @return mixed
 */
if (function_exists('env')) {
    function env(string $key, mixed $fallback): mixed
    {
        return Env::getEnv($key, $fallback);
    }
}


/**
 * Set new value for given environment key, or add it as new data
 *
 * @param string $key
 * @param mixed|null $value
 * @return void
 */
if (function_exists('set_env')) {
    function set_env(string $key, mixed $value): void
    {
        Env::setEnv($key, $value);
    }
}

/**
 * Remove given environment key
 *
 * @param string $key
 * @return bool
 */
if (function_exists('remove_env')) {
    function remove_env(string $key): bool
    {
        return Env::removeEnv($key);
    }
}
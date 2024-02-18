<?php

namespace Maocae\Env;

use Maocae\Support\Patterns\Singleton;

class Env extends Singleton
{
    /**
     * Prevent any change on any applied environment variable
     *
     * @var bool $mutable
     */
    protected bool $mutable = false;

    /**
     * Set to true to only return local environment variables (set by the operating system or putenv).
     *
     * @var bool $local_only
     */
    protected bool $local_only = true;

    /**
     * Mutable property setter
     *
     * @param bool $mutable
     * @return void
     */
    public function setMutable(bool $mutable = true): void
    {
        $this->mutable = $mutable;
    }

    /**
     * Local only property setter
     *
     * @param bool $local_only
     * @return void
     */
    public function setLocalOnly(bool $local_only = true): void
    {
        $this->local_only = $local_only;
    }

    /**
     * Get environment data from given key, and return fallback if data presented
     *
     * @param string $key
     * @param mixed|null $fallback
     * @return mixed
     */
    public function getEnv(string $key, mixed $fallback = null): mixed
    {
        return getenv($key, $this->local_only) ?: $_ENV[$key] ?? $fallback;
    }

    /**
     * Set new value for given environment key, or add it as new data
     *
     * @param string $key
     * @param mixed|null $value
     * @return void
     */
    public function setEnv(string $key, mixed $value = null): void
    {
        $_ENV[$key] = $value;
    }

    /**
     * Remove given environment key
     *
     * @param string $key
     * @return bool
     */
    public function removeEnv(string $key): bool
    {
        if (isset($_ENV[$key])) {
            unset($_ENV[$key]);
            return true;
        }
        return putenv($key);
    }
}
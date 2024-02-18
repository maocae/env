<?php

namespace Maocae\Env;

use Maocae\Env\Exceptions\ImmutableKeyException;
use Maocae\Env\Interfaces\ParserInterface;
use Maocae\Support\Patterns\Singleton;

class Env extends Singleton
{
    /**
     * File parser instance
     *
     * @var ParserInterface $parser
     */
    protected ParserInterface $parser;

    /**
     * Prevent any change on any applied environment variable
     *
     * @var bool $immutable
     */
    
    protected bool $immutable = false;
    /**
     * Set whether the new variable gonna stored on $_ENV or putenv
     *
     * @var bool $store_in_env_variables
     */

    protected bool $store_in_env_variables = true;
    /**
     * Set to true to only return local environment variables (set by the operating system or putenv).
     *
     * @var bool $local_only
     */
    protected bool $local_only = true;

    /**
     * Return parser instance
     *
     * @return ParserInterface
     */
    public function getParser(): ParserInterface
    {
        return $this->parser;
    }

    /**
     * Set environment file parser
     *
     * @param string|object $parser
     * @return void
     */
    public function setParser(string|object $parser): void
    {
        if (is_string($parser)) {
            $parser = new $parser();
        }

        $this->parser = $parser;
    }

    /**
     * Load environment data from file
     *
     * @param string $path
     * @return void
     */
    public function loadFromFile(string $path): void
    {
        $this->parser->loadFromFile($path);
    }

    /**
     * Set whether the new variable gonna stored on $_ENV or putenv
     *
     * @param bool $store_in_env_variables
     * @return void
     */
    public function setStoreInEnvironmentVariables(bool $store_in_env_variables = true): void
    {
        $this->store_in_env_variables = $store_in_env_variables;
    }

    /**
     * immutable property setter
     *
     * @param bool $immutable
     * @return void
     */
    public function setImmutable(bool $immutable = true): void
    {
        $this->immutable = $immutable;
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
        if ($this->immutable) {
            throw new ImmutableKeyException();
        }

        $this->store_in_env_variables ? putenv("$key=$value") : $_ENV[$key] = $value;
    }

    /**
     * Get all available environment value
     *
     * @return array
     */
    public function getAll(): array
    {
        return array_merge(getenv(), $_ENV);
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
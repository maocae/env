<?php

namespace Maocae\Env\Interfaces;

interface ParserInterface
{
    /**
     * Load environment data from file
     *
     * @param string $path
     * @return void
     */
    public function loadFromFile(string $path): void;
}
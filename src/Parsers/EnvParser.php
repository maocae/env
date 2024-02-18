<?php

namespace Maocae\Env\Parsers;

use Maocae\Env\Exceptions\EnvFileNotFoundException;
use Maocae\Env\Exceptions\InvalidEnvFileContent;
use Maocae\Env\Facades\Env;
use Maocae\Env\Interfaces\ParserInterface;

class EnvParser implements ParserInterface
{
    /**
     * Token to tell the parser that the line is a comment
     *
     * @var string $comment_token
     */
    protected string $comment_token = "#";

    /**
     * Load environment data from file
     *
     * @param string $path
     * @return void
     */
    public function loadFromFile(string $path): void
    {
        $contents = $this->loadContent($path);

        $this->parseContent($contents);
    }

    /**
     * Check if environment file is readable and return its content
     *
     * @param string $path
     * @return string
     */
    protected function loadContent(string $path): string
    {
        if (!is_readable($path)) {
            throw new EnvFileNotFoundException();
        }

        return file_get_contents($path);
    }

    /**
     * Parse given content, get the environment data and store it
     *
     * @param string $contents
     * @return void
     */
    protected function parseContent(string $contents): void
    {
        $lines = explode("\n", $contents);
        $unfinished_key = null;
        $unfinished_value = null;

        foreach ($lines as $line) {
            if ($unfinished_key) {
                $key = $unfinished_key;
                $value = trim($unfinished_value . "\n" . $line);
            } else {
                $line = trim($line);


                if ($this->isLineEmptyOrAComment($line)) {
                    continue;
                }

                $tokens = explode("=", $line, 2);
                $key = $tokens[0];

                if (!isset($tokens[1])) {
                    throw new InvalidEnvFileContent();
                }

                $value = $tokens[1];
            }

            if ($wrapper = $this->getLineWrapper($value)) {
                if (!str_ends_with($value, $wrapper)) {
                    $unfinished_key = $key;
                    $unfinished_value = $value;
                    continue;
                }

                if (!preg_match('/^' . $wrapper . '[^' . $wrapper . ']*' . $wrapper . '$/', $value)) {
                    var_dump($value);
                    throw new InvalidEnvFileContent();
                }
                $unfinished_key = null;
                $unfinished_value = null;
            }

            Env::setEnv($key, $value);
        }

        if ($unfinished_key) {
            throw new InvalidEnvFileContent();
        }
    }

    /**
     * Check if given line is empty or just a comment
     *
     * @param string $line
     * @return bool
     */
    protected function isLineEmptyOrAComment(string $line): bool
    {
        return empty($line) || str_starts_with($line, $this->comment_token);
    }

    /**
     * Get current line wrapper if there's any
     *
     * @param string $value
     * @return string|null
     */
    protected function getLineWrapper(string $value): ?string
    {
        if (str_starts_with($value, '"')) {
            return '"';
        }
        if (str_starts_with($value, "'")) {
            return "'";
        }

        return null;
    }
}
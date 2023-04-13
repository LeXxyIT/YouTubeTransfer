<?php

declare(strict_types=1);

namespace LeXxyIT\EnvParser;

use Exception;

/**
 * Read and parsing the .env file to add new variables to the global environment
 */
class EnvParser
{

    /**
     * @param string $path
     * @throws Exception
     */
    public static function load(string $path): void
    {
        if (is_file($path)) {
            $file = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (!empty($file)) {
                foreach ($file as $line) {
                    if (strpos($line, '#') !== 0) {
                        $line = trim($line);
                        $line = explode('=', $line, 2);
                        if (!empty($line[0]) && !empty($line[1])) {
                            if (!array_key_exists($line[0], $_ENV)) {
                                $_ENV[$line[0]] = $line[1];
                            }
                        }
                    }
                }
            }
        } else {
            throw new Exception('Add correct path to .env file');
        }
    }

}

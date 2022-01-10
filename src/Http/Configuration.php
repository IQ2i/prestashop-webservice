<?php

declare(strict_types=1);

/*
 * This file is part of the PrestashopWebservice package.
 *
 * (c) Loïc Sapone <loic@sapone.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IQ2i\PrestashopWebservice\Http;

use IQ2i\PrestashopWebservice\Exception\InvalidArgument;

class Configuration
{
    public const OPTION_URL = 'url';
    public const OPTION_KEY = 'key';

    private const AVAILABLE_OPTIONS = [
        self::OPTION_URL   => true,
        self::OPTION_KEY   => true,
    ];

    private array $data = [];

    public static function create(array $options): self
    {
        if (0 < count($invalidOptions = array_diff_key($options, self::AVAILABLE_OPTIONS))) {
            throw new InvalidArgument(sprintf('Unknown option(s) "%s".', implode('", "', array_keys($invalidOptions))));
        }

        if (0 < count($missingOptions = array_diff_key(self::AVAILABLE_OPTIONS, $options))) {
            throw new InvalidArgument(sprintf('Missing required option(s) "%s".', implode('", "', array_keys($missingOptions))));
        }

        $configuration = new self();
        $configuration->data[self::OPTION_URL] = rtrim($options[self::OPTION_URL], '/').'/';
        $configuration->data[self::OPTION_KEY] = $options[self::OPTION_KEY];

        return $configuration;
    }

    public function get(string $name): mixed
    {
        if (!isset(self::AVAILABLE_OPTIONS[$name])) {
            throw new InvalidArgument(sprintf('Unknown option "%s".', $name));
        }

        return $this->data[$name];
    }

    public function has(string $name): bool
    {
        if (!isset(self::AVAILABLE_OPTIONS[$name])) {
            throw new InvalidArgument(sprintf('Unknown option "%s".', $name));
        }

        return isset($this->data[$name]);
    }
}

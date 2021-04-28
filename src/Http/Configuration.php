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
    public const OPTION_DEBUG = 'debug';

    private const AVAILABLE_OPTIONS = [
        self::OPTION_URL   => true,
        self::OPTION_KEY   => true,
        self::OPTION_DEBUG => true,
    ];
    private const REQUIRED_OPTIONS = [
        self::OPTION_URL => true,
        self::OPTION_KEY => true,
    ];
    private const DEFAULT_OPTIONS = [
        self::OPTION_DEBUG => true,
    ];

    private $data = [];

    public static function create(array $options): self
    {
        if (0 < \count($invalidOptions = \array_diff_key($options, self::AVAILABLE_OPTIONS))) {
            throw new InvalidArgument(\sprintf('Unknown option(s) "%s" passed to "%s::%s". ', \implode('", "', \array_keys($invalidOptions)), __CLASS__, __METHOD__));
        }

        if (0 < \count($missingOptions = \array_diff_key(self::REQUIRED_OPTIONS, $options))) {
            throw new InvalidArgument(\sprintf('Missing required option(s) "%s" passed to "%s::%s". ', \implode('", "', \array_keys($missingOptions)), __CLASS__, __METHOD__));
        }

        $configuration = new self();
        self::parseConfiguration($configuration, self::DEFAULT_OPTIONS);
        self::parseConfiguration($configuration, $options);

        return $configuration;
    }

    /**
     * @return null|mixed
     */
    public function get(string $name)
    {
        if (!isset(self::AVAILABLE_OPTIONS[$name])) {
            throw new InvalidArgument(\sprintf('Invalid option "%s" passed to "%s::%s". ', $name, __CLASS__, __METHOD__));
        }

        return $this->data[$name] ?? null;
    }

    public function has(string $name): bool
    {
        if (!isset(self::AVAILABLE_OPTIONS[$name])) {
            throw new InvalidArgument(\sprintf('Invalid option "%s" passed to "%s::%s". ', $name, __CLASS__, __METHOD__));
        }

        return isset($this->data[$name]);
    }

    private static function parseConfiguration(Configuration $configuration, array $options)
    {
        foreach ($options as $key => $value) {
            $configuration->data[$key] = $value;
        }
    }
}

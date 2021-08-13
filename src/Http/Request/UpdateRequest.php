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

namespace IQ2i\PrestashopWebservice\Http\Request;

use IQ2i\PrestashopWebservice\Http\Query\Display;

class UpdateRequest extends Request
{
    private $resource;
    private $identifier;

    public function __construct(string $resource, int $identifier)
    {
        $this->resource = $resource;
        $this->identifier = $identifier;
    }

    public function getMethod(): string
    {
        return Request::PUT;
    }

    public function getUri(): string
    {
        return sprintf('%s/%d', $this->resource, $this->identifier);
    }

    public function getAvailableQueryAttributes(): array
    {
        return [
            Display::class,
        ];
    }
}

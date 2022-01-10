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

use IQ2i\PrestashopWebservice\Http\QueryAttribute\Display;

class GetRequest extends Request
{
    public function __construct(
        private string $resource,
        private int $identifier
    ) {
    }

    public function getMethod(): string
    {
        return Request::GET;
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

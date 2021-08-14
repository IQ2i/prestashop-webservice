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
use IQ2i\PrestashopWebservice\Http\QueryAttribute\Filter;
use IQ2i\PrestashopWebservice\Http\QueryAttribute\Limit;
use IQ2i\PrestashopWebservice\Http\QueryAttribute\Sort;

class ListRequest extends Request
{
    private $resource;

    public function __construct(string $resource)
    {
        $this->resource = $resource;
    }

    public function getMethod(): string
    {
        return Request::GET;
    }

    public function getUri(): string
    {
        return $this->resource;
    }

    public function getAvailableQueryAttributes(): array
    {
        return [
            Display::class,
            Filter::class,
            Limit::class,
            Sort::class,
        ];
    }
}

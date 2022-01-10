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

class Response
{
    public function __construct(
        private int $statusCode,
        private array $content,
        private array $headers = []
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}

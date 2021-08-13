# PrestaShop API client

[![Continuous Integration](https://github.com/IQ2i/prestashop-webservice/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/IQ2i/prestashop-webservice/actions/workflows/continuous-integration.yml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/IQ2i/prestashop-webservice/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/IQ2i/prestashop-webservice/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/IQ2i/prestashop-webservice/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/IQ2i/prestashop-webservice/?branch=main)

A PHP client library to interact with PrestaShop API.

## Installation

```bash
composer require iq2i/prestashop-webservice
```

## Usage

1. Create a client instance:

```php
use IQ2i\PrestashopWebservice\Http\Client;

$client = new Client([
    'url' => 'https://my-prestashop.com/api/',
    'key' => '6MBWZM37S6XCZXYT81GD6XD41SKZ14TP',
]);
```

2. Create CRUD request:

```php
use IQ2i\PrestashopWebservice\Http\Request\ListRequest;

/** GET /api/categories */
$request = new ListRequest('categories');
```

```php
use IQ2i\PrestashopWebservice\Http\Request\GetRequest;

/** GET /api/categories/1 */
$request = new GetRequest('categories', 1);
```

```php
use IQ2i\PrestashopWebservice\Http\Request\CreateRequest;

/** POST /api/categories */
$request = new CreateRequest('categories');
$request->setBody('XML content');
```

```php
use IQ2i\PrestashopWebservice\Http\Request\UpdateRequest;

/** PUT /api/categories/1 */
$request = new UpdateRequest('categories', 1);
$request->setBody('XML content');
```

```php
use IQ2i\PrestashopWebservice\Http\Request\DeleteRequest;

/** DELETE /api/categories/1 */
$request = new DeleteRequest('categories', 1);
```

3. Execute request
```php
$response = $client->execute($request);
```

4. Use client's response:

```php
$statusCode = $response->getStatusCode();
$header = $response->getHeaders();
$content = $response->getContent();
```

The response's content is an array, client automatically decode XML.

## Issues and feature requests

Please report issues and request features at https://github.com/iq2i/prestashop-webservice/issues.

## License

This bundle is under the MIT license.
For the whole copyright, see the [LICENSE](LICENSE) file distributed with this source code.
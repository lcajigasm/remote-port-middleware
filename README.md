# Remote Port Middleware
[![Latest Stable Version](https://poser.pugx.org/luisinder/remote-port-middleware/v/stable)](https://packagist.org/packages/luisinder/remote-port-middleware)
[![Total Downloads](https://poser.pugx.org/luisinder/remote-port-middleware/downloads)](https://packagist.org/packages/luisinder/remote-port-middleware)

PSR-7 / PSR-15 middleware that determines the client's remote TCP port (from the `REMOTE_PORT` server param) and stores it as a `ServerRequest` attribute named `remotePort`.

Works with:
- Slim 4+ (PSR-15 single-pass)
- Slim 3 (legacy double-pass) – still supported for backwards compatibility
- Any PSR-15 compatible framework (Mezzio, etc.)

## Requirements

- PHP >= 8.0
- psr/http-message ^1.0 || ^2.0
- psr/http-server-middleware ^1.0

## Installation

```bash
composer require luisinder/remote-port-middleware
```

## How it works

On each request the middleware inspects `$request->getServerParams()['REMOTE_PORT']` (if present) and attaches it to the request as `remotePort` (integer or `null` if missing).

## Usage (Slim 4+)

```php
use Slim\Factory\AppFactory;
use Luisinder\Middleware\RemotePort;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->add(RemotePort::class); // or new RemotePort()

$app->get('/', function ($request, $response) {
    $remotePort = $request->getAttribute('remotePort');
    $response->getBody()->write('Remote port: ' . ($remotePort ?? 'unknown'));
    return $response;
});

$app->run();
```

### Container registration (optional)

If you prefer adding via DI container (e.g. using PHP-DI):

```php
$container->set(RemotePort::class, function() { return new RemotePort(); });
$app->add(RemotePort::class);
```

## Usage (Slim 3 legacy)

```php
$app->add(new Luisinder\Middleware\RemotePort());

$app->get('/', function ($request, $response) {
    $remotePort = $request->getAttribute('remotePort');
    return $response->write('Remote port: ' . ($remotePort ?? 'unknown'));
});
```

## Attribute name

The attribute key is `remotePort`. Example:

```php
$remotePort = $request->getAttribute('remotePort'); // int|null
```

## Error handling & edge cases

If `REMOTE_PORT` is missing the attribute value will be `null`.

## Testing

You can simulate a request by constructing a PSR-7 `ServerRequest` with a custom server params array:

```php
$request = $request->withServerParams(['REMOTE_PORT' => 54321]);
```

## Contributing

PRs and issues are welcome. Please include tests where possible.

## License

BSD-3-Clause. See the `LICENSE` file for details.
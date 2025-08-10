<?php

namespace Luisinder\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * RemotePort middleware
 *
 * Adds the client remote TCP port (REMOTE_PORT) as request attribute 'remotePort'.
 *
 * Supports:
 *  - PSR-15 (Slim 4+, Mezzio, etc.) via process().
 *  - Legacy Slim 3 style invocation via __invoke($request, $response, $next) for backwards compatibility.
 */
class RemotePort implements MiddlewareInterface
{
	/**
	 * PSR-15 entry point
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$remotePort = $this->determineClientRemotePort($request);
		$request = $request->withAttribute('remotePort', $remotePort);
		return $handler->handle($request);
	}

	/**
	 * Slim 3 legacy support (double-pass middleware signature).
	 * If used in a Slim 3 stack, this method will be invoked instead of process().
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
	{
		if (!$next) {
			return $response;
		}
		$remotePort = $this->determineClientRemotePort($request);
		$request = $request->withAttribute('remotePort', $remotePort);
		return $next($request, $response);
	}

	protected function determineClientRemotePort(ServerRequestInterface $request): ?int
	{
		$serverParams = $request->getServerParams();
		return isset($serverParams['REMOTE_PORT']) ? (int)$serverParams['REMOTE_PORT'] : null;
	}
}
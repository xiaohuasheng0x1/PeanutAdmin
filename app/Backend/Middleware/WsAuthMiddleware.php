<?php


namespace App\Backend\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class WsAuthMiddleware implements MiddlewareInterface
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getQueryParams()['token'] ?? null;
        try {
            if ($token && user()->check($token)) {
                return $handler->handle($request);
            } else {
                return container()->get(\Hyperf\HttpServer\Contract\ResponseInterface::class)->raw(t('jwt.validate_fail'));
            }
        } catch(\Exception $e) {
            return container()->get(\Hyperf\HttpServer\Contract\ResponseInterface::class)->raw($e->getMessage());
        }
    }
}
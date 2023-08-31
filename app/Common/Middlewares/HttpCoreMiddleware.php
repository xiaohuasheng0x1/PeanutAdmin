<?php


declare(strict_types=1);
namespace App\Common\Middlewares;

use Hyperf\Context\Context;
use Hyperf\HttpMessage\Stream\SwooleStream;
use App\Common\Helper\PaCode;
use Hyperf\Codec\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\CoreMiddleware;

class HttpCoreMiddleware extends CoreMiddleware
{
    /**
     * 跨域
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = Context::get(ResponseInterface::class);
        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods','GET,PUT,POST,DELETE,OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            // Headers 可以根据实际情况进行改写。
            ->withHeader('Access-Control-Allow-Headers', 'accept-language,authorization,lang,uid,token,Keep-Alive,User-Agent,Cache-Control,Content-Type');

        Context::set(ResponseInterface::class, $response);

        if ($request->getMethod() == 'OPTIONS') {
            return $response;
        }

        return parent::process($request,$handler);
    }

    /**
     * Handle the response when cannot found any routes.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function handleNotFound(ServerRequestInterface $request): ResponseInterface
    {
        $format = [
            'success' => false,
            'code'    => PaCode::NOT_FOUND,
            'message' => t('peanutadmin.not_found')
        ];
        return $this->response()->withHeader('Server', 'PeanutAdmin')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(404)
            ->withBody(new SwooleStream(Json::encode($format)));
    }

    /**
     * Handle the response when the routes found but doesn't match any available methods.
     * @param array $methods
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function handleMethodNotAllowed(
        array $methods,
        ServerRequestInterface $request): ResponseInterface
    {
        $format = [
            'success' => false,
            'code'    => PaCode::METHOD_NOT_ALLOW,
            'message' => t('peanutadmin.allow_method', ['method' => implode(',', $methods)])
        ];
        return $this->response()->withHeader('Server', 'PeanutAdmin')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(405)
            ->withBody(new SwooleStream(Json::encode($format)));
    }
}
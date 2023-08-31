<?php
declare(strict_types=1);

namespace App\Common\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use App\Common\Exception\NoPermissionException;
use App\Common\Helper\PaCode;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class TokenExceptionHandler
 * @package Peanut\Exception\Handler
 */
class NoPermissionExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $this->stopPropagation();
        $format = [
            'success' => false,
            'message' => $throwable->getMessage(),
            'code'    => PaCode::NO_PERMISSION,
        ];
        return $response->withHeader('Server', 'PeanutAdmin')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods','GET,PUT,POST,DELETE,OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'accept-language,authorization,lang,uid,token,Keep-Alive,User-Agent,Cache-Control,Content-Type')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(403)->withBody(new SwooleStream(Json::encode($format)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof NoPermissionException;
    }
}

<?php


declare(strict_types = 1);
namespace App\Common\Event;

class Operation
{
    /**
     * @var array
     */
    protected array $requestInfo;


    public function __construct(array $requestInfo)
    {
        $this->requestInfo = $requestInfo;
    }

    public function getRequestInfo(): array
    {
        return $this->requestInfo;
    }
}
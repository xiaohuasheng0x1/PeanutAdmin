<?php


declare(strict_types = 1);
namespace App\Common\Event;

class UserLoginBefore
{
    public array $inputData;

    public function __construct(array $inputData)
    {
        $this->inputData = $inputData;
    }
}
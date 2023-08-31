<?php


declare(strict_types = 1);
namespace App\Common\Event;

class UserAdd
{
    public array $userinfo;

    public function __construct(array $userinfo)
    {
        $this->userinfo = $userinfo;
    }
}
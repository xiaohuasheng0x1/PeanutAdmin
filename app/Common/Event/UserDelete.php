<?php


declare(strict_types = 1);
namespace App\Common\Event;

class UserDelete
{
    public array $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }
}
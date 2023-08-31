<?php


declare(strict_types=1);
namespace App\Common\Generator;

interface CodeGenerator
{
    public function generator();

    public function preview();
}
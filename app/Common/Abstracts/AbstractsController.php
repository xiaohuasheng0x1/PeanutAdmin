<?php
declare(strict_types=1);
namespace App\Common\Abstracts;

use App\Common\Peanut;
use App\Common\Traits\ControllerTrait;
use Hyperf\Di\Annotation\Inject;

/**
 * 后台控制器基类
 * Class AbstractsController
 * @package Peanut
 */
abstract class AbstractsController
{
    use ControllerTrait;

    /**
     * @var Peanut
     */
    #[Inject]
    protected Peanut $peanut;
}

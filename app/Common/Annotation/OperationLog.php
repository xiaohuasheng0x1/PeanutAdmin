<?php


declare(strict_types = 1);
namespace App\Common\Annotation;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 记录操作日志注解。
 */
#[Attribute(Attribute::TARGET_METHOD)]
class OperationLog extends AbstractAnnotation
{
    /**
     * 菜单名称
     * @var string|null $menuName
     */
    public function __construct(public ?string $menuName = null) {}
}
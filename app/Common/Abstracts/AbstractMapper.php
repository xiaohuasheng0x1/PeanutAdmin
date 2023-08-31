<?php


declare (strict_types = 1);
namespace App\Common\Abstracts;

use App\Common\Traits\MapperTrait;
use Hyperf\Context\Context;
use App\Common\PaModel;

/**
 * Class AbstractMapper
 * @package Peanut\Abstracts
 */
abstract class AbstractMapper
{
    use MapperTrait;

    /**
     * @var PaModel
     */
    public $model;
    
    abstract public function assignModel();

    public function __construct()
    {
        $this->assignModel();
    }

    /**
     * 把数据设置为类属性
     * @param array $data
     */
    public static function setAttributes(array $data)
    {
        Context::set('attributes', $data);
    }

    /**
     * 魔术方法，从类属性里获取数据
     * @param string $name
     * @return mixed|string
     */
    public function __get(string $name)
    {
        return $this->getAttributes()[$name] ?? '';
    }

    /**
     * 获取数据
     * @return array
     */
    public function getAttributes(): array
    {
        return Context::get('attributes', []);
    }
}

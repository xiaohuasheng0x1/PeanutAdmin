<?php


declare(strict_types=1);
namespace App\Common\Generator;

use Psr\Container\ContainerInterface;

abstract class PaGenerator
{
    /**
     * @var string
     */
    protected string $stubDir;

    /**
     * @var string
     */
    protected string $namespace;

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    public const NO  = 1;
    public const YES = 2;

    /**
     * PaGenerator constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setStubDir(BASE_PATH . '/app/Common/Generator/Stubs/');
        $this->container = $container;
    }

    public function getStubDir(): string
    {
        return $this->stubDir;
    }

    public function setStubDir(string $stubDir)
    {
        $this->stubDir = $stubDir;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    public function replace(): self
    {
        return $this;
    }
}
<?php


declare(strict_types=1);
namespace App\Common\Event;

use App\Backend\Model\Uploadfile;
use League\Flysystem\Filesystem;

class RealDeleteUploadFile
{
    protected Uploadfile $model;

    protected bool $confirm = true;

    protected Filesystem $filesystem;

    public function __construct(Uploadfile $model, Filesystem $filesystem)
    {
        $this->model = $model;
        $this->filesystem = $filesystem;
    }

    /**
     * 获取当前模型实例
     * @return Uploadfile
     */
    public function getModel(): Uploadfile
    {
        return $this->model;
    }

    /**
     * 获取文件处理系统
     * @return Filesystem
     */
    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    /**
     * 是否删除
     * @return bool
     */
    public function getConfirm(): bool
    {
        return $this->confirm;
    }

    public function setConfirm(bool $confirm): void
    {
        $this->confirm = $confirm;
    }
}
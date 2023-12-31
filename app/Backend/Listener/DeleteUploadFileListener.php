<?php

declare(strict_types=1);
namespace App\Backend\Listener;

use App\Backend\Model\Uploadfile;
use App\Common\Event\RealDeleteUploadFile;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use League\Flysystem\FilesystemException;

/**
 * Class DeleteUploadFileListener
 * @package Backend\System\Listener
 */
#[Listener]
class DeleteUploadFileListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            RealDeleteUploadFile::class
        ];
    }

    /**
     * @param object $event
     * @throws FilesystemException
     */
    public function process(object $event): void
    {
        $filePath = $this->getFilePath($event->getModel());
        try {
            $event->getFilesystem()->delete($filePath);
        } catch (\Exception $e) {
            // 文件删除失败，跳过删除数据
            $event->setConfirm(false);
        }
    }

    /**
     * 获取文件路径
     * @param Uploadfile $model
     * @return string
     */
    public function getFilePath(Uploadfile $model): string
    {
        return $model->storage_path.'/'.$model->object_name;
    }

}
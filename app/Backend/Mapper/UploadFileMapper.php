<?php
declare(strict_types=1);
namespace App\Backend\Mapper;

use App\Backend\Model\LoginLog;
use App\Backend\Model\Uploadfile;
use App\Common\Abstracts\AbstractMapper;
use Hyperf\Database\Model\Builder;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Filesystem\FilesystemFactory;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Class UserMapper
 * @package App\System\Mapper
 */
class UploadFileMapper extends AbstractMapper
{
    /**
     * @var LoginLog
     */
    public $model;

    #[Inject]
    protected EventDispatcherInterface $evDispatcher;

    #[Inject]
    protected ContainerInterface $container;


    public function assignModel()
    {
        $this->model = Uploadfile::class;
    }

    /**
     * 通过hash获取上传文件的信息
     * @param string $hash
     * @return Builder|\Hyperf\Database\Model\Model|object|null
     */
    public function getFileInfoByHash(string $hash)
    {
        $model = $this->model::query()->where('hash', $hash)->first();
        if (! $model) {
            $model = $this->model::withTrashed()->where('hash', $hash)->first(['id']);
            $model && $model->forceDelete();
            return null;
        }
        return $model;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['storage_mode'])) {
            $query->where('storage_mode', $params['storage_mode']);
        }
        if (!empty($params['origin_name'])) {
            $query->where('origin_name', 'like', '%'.$params['origin_name'].'%');
        }
        if (!empty($params['storage_path'])) {
            $query->where('storage_path', 'like', $params['storage_path'].'%');
        }
        if (!empty($params['mime_type'])) {
            $query->where('mime_type', 'like', $params['mime_type'].'/%');
        }
        if (!empty($params['minDate']) && !empty($params['maxDate'])) {
            $query->whereBetween(
                'created_at',
                [$params['minDate'] . ' 00:00:00', $params['maxDate'] . ' 23:59:59']
            );
        }
        return $query;
    }

    public function realDelete(array $ids): bool
    {
        foreach ($ids as $id) {
            $model = $this->model::withTrashed()->find($id);
            if ($model) {
                $storageMode = match ( $model->storage_mode ) {
                    '1' => 'local',
                    '2' => 'oss',
                    '3' => 'qiniu',
                    '4' => 'cos',
                    '5' => 'ftp',
                    '6' => 'memory',
                    '7' => 's3',
                    '8' => 'minio',
                    default => 'local',
                };
                $event = new \App\Common\Event\RealDeleteUploadFile(
                    $model, $this->container->get(FilesystemFactory::class)->get($storageMode)
                );
                $this->evDispatcher->dispatch($event);
                if ($event->getConfirm()) {
                    $model->forceDelete();
                }
            }
        }
        unset($event);
        return true;
    }

    /**
     * 检查数据库中是否存在该目录数据
     * @param string $path
     * @return bool
     */
    public function checkDirDbExists(string $path): bool
    {
        return $this->model::withTrashed()
                ->where('storage_path', $path)
                ->orWhere('storage_path', 'like', $path . '/%')
                ->exists();
    }
}
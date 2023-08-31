<?php

declare(strict_types=1);
namespace App\Backend\Service;

use App\Backend\Mapper\UploadFileMapper;
use App\Common\Abstracts\AbstractService;
use App\Common\Exception\NormalStatusException;
use App\Common\PaUpload;
use Hyperf\Collection\Collection;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Upload\UploadedFile;

/**
 * 文件上传业务
 * Class LoginLogService
 * @package Backend\System\Service
 */
class UploadFileService extends AbstractService
{
    /**
     * @var ConfigInterface
     */
    #[Inject]
    protected $config;

    /**
     * @var UploadFileMapper
     */
    public $mapper;

    /**
     * @var PaUpload
     */
    protected PaUpload $paUpload;


    public function __construct(UploadFileMapper $mapper, PaUpload $paUpload)
    {
        $this->mapper = $mapper;
        $this->paUpload = $paUpload;
    }

    /**
     * 上传文件
     * @param UploadedFile $uploadedFile
     * @param array $config
     * @return array
     * @throws \League\Flysystem\FileExistsException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function upload(UploadedFile $uploadedFile, array $config = []): array
    {
        try {
            $hash = md5_file($uploadedFile->getPath() . '/' . $uploadedFile->getFilename());
            if ($model = $this->mapper->getFileInfoByHash($hash)) {
                return $model->toArray();
            }
        } catch (\Exception $e) {
            throw new NormalStatusException('获取文件Hash失败', 500);
        }
        $data = $this->paUpload->upload($uploadedFile, $config);
        if ($this->save($data)) {
            return $data;
        } else {
            return [];
        }
    }

    public function chunkUpload(array $data): array
    {
        if ($model = $this->mapper->getFileInfoByHash($data['hash'])) {
            return $model->toArray();
        }
        $result = $this->paUpload->handleChunkUpload($data);
        if (isset($result['hash'])) {
            $this->save($result);
        }
        return $result;
    }

    /**
     * 获取当前目录下所有文件（包含目录）
     * @param array $params
     * @return array
     */
    public function getAllFile(array $params = []): array
    {
        return $this->getArrayToPageList($params);
    }

    /**
     * 数组数据搜索器
     * @param Collection $collect
     * @param array $params
     * @return Collection
     */
    protected function handleArraySearch(Collection $collect, array $params): Collection
    {
        if ($params['name'] ?? false) {
            $collect = $collect->filter(function ($row) use ($params) {
                return \App\Common\Helper\Str::contains($row['name'], $params['name']);
            });
        }

        if ($params['label'] ?? false) {
            $collect = $collect->filter(function ($row) use ($params) {
                return \App\Common\Helper\Str::contains($row['label'], $params['label']);
            });
        }
        return $collect;
    }

    /**
     * 保存网络图片
     * @param array $data ['url', 'path']
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveNetworkImage(array $data): array
    {
        $data = $this->paUpload->handleSaveNetworkImage($data);
        if (! isset($data['id']) && $this->save($data)) {
            return $data;
        } else {
            return $data;
        }
    }

    /**
     * 通过hash获取文件信息
     * @param string $hash
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     */
    public function readByHash(string $hash)
    {
        return $this->mapper->getFileInfoByHash($hash);
    }
}

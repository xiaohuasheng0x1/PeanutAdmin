<?php
/** @noinspection PhpIllegalStringOffsetInspection */
/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */


declare(strict_types=1);
namespace App\Common\Generator;

use App\Backend\Model\GenerateColumns;
use App\Backend\Model\GenerateTables;
use App\Backend\Service\GenerateColumnsService;
use App\Common\Exception\NormalStatusException;
use App\Common\Generator\Traits\MapperGeneratorTraits;
use App\Common\Helper\Str;
use Hyperf\Utils\Filesystem\Filesystem;

/**
 * Mapper类生成
 * Class MapperGenerator
 * @package Peanut\Generator
 */
class MapperGenerator extends PaGenerator implements CodeGenerator
{
    use MapperGeneratorTraits;

    /**
     * @var GenerateTables
     */
    protected GenerateTables $model;

    /**
     * @var string
     */
    protected string $codeContent;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * 设置生成信息
     * @param GenerateTables $model
     * @return MapperGenerator
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function setGenInfo(GenerateTables $model): MapperGenerator
    {
        $this->model = $model;
        $this->filesystem = make(Filesystem::class);
        if (empty($model->menu_name)) {
            throw new NormalStatusException(t('setting.gen_code_edit'));
        }
        $this->setNamespace($this->model->namespace);
        return $this->placeholderReplace();
    }

    /**
     * 生成代码
     */
    public function generator(): void
    {
        if ($this->model->generate_type === 1) {
            $path = BASE_PATH . "/runtime/generate/php/app/Backend/Mapper/";
        } else {
            $path = BASE_PATH . "/app/Backend/Mapper/";
        }
        $this->filesystem->exists($path) || $this->filesystem->makeDirectory($path, 0755, true, true);
        $this->filesystem->put($path . "{$this->getClassName()}.php", $this->replace()->getCodeContent());
    }

    /**
     * 预览代码
     */
    public function preview(): string
    {
        return $this->replace()->getCodeContent();
    }

    /**
     * 获取生成的类型
     * @return string
     */
    public function getType(): string
    {
        return ucfirst($this->model->type);
    }

    /**
     * 获取模板地址
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return $this->getStubDir().$this->getType().'/mapper.stub';
    }

    /**
     * 读取模板内容
     * @return string
     */
    protected function readTemplate(): string
    {
        return $this->filesystem->sharedGet($this->getTemplatePath());
    }

    /**
     * 占位符替换
     */
    protected function placeholderReplace(): MapperGenerator
    {
        $this->setCodeContent(str_replace(
            $this->getPlaceHolderContent(),
            $this->getReplaceContent(),
            $this->readTemplate()
        ));

        return $this;
    }

    /**
     * 获取要替换的占位符
     */
    protected function getPlaceHolderContent(): array
    {
        return [
            '{NAMESPACE}',
            '{USE}',
            '{COMMENT}',
            '{CLASS_NAME}',
            '{MODEL}',
            '{FIELD_ID}',
            '{FIELD_PID}',
            '{FIELD_NAME}',
            '{SEARCH}'
        ];
    }

    /**
     * 获取要替换占位符的内容
     */
    protected function getReplaceContent(): array
    {
        return [
            $this->initNamespace(),
            $this->getUse(),
            $this->getComment(),
            $this->getClassName(),
            $this->getModelName(),
            $this->getFieldIdName(),
            $this->getFieldPidName(),
            $this->getFieldName(),
            $this->getSearch()
        ];
    }

    /**
     * 初始化服务类命名空间
     * @return string
     */
    protected function initNamespace(): string
    {
        return $this->getNamespace() . "\\Mapper";
    }

    /**
     * 获取控制器注释
     * @return string
     */
    protected function getComment(): string
    {
        return $this->model->menu_name. 'Mapper类';
    }

    /**
     * 获取使用的类命名空间
     * @return string
     */
    protected function getUse(): string
    {
        return <<<UseNamespace
use {$this->getNamespace()}\\Model\\{$this->getBusinessName()};
UseNamespace;
    }

    /**
     * 获取类名称
     * @return string
     */
    protected function getClassName(): string
    {
        return $this->getBusinessName().'Mapper';
    }

    /**
     * 获取Model类名称
     * @return string
     */
    protected function getModelName(): string
    {
        return $this->getBusinessName();
    }

    /**
     * 获取树表ID
     * @return string
     */
    protected function getFieldIdName(): string
    {
        if ($this->getType() == 'Tree') {
            if ( $this->model->options['tree_id'] ?? false ) {
                return $this->model->options['tree_id'];
            } else {
                return 'id';
            }
        }
        return '';
    }

    /**
     * 获取树表父ID
     * @return string
     */
    protected function getFieldPidName(): string
    {
        if ($this->getType() == 'Tree') {
            if ( $this->model->options['tree_pid'] ?? false ) {
                return $this->model->options['tree_pid'];
            } else {
                return 'parent_id';
            }
        }
        return '';
    }

    /**
     * 获取树表显示名称
     * @return string
     */
    protected function getFieldName(): string
    {
        if ($this->getType() == 'Tree') {
            if ( $this->model->options['tree_name'] ?? false ) {
                return $this->model->options['tree_name'];
            } else {
                return 'name';
            }
        }
        return '';
    }

    /**
     * 获取搜索内容
     * @return string
     */
    protected function getSearch(): string
    {
        /* @var GenerateColumns $model */
        $model = make(GenerateColumnsService::class)->mapper->getModel();
        $columns = $model->newQuery()
            ->where('table_id', $this->model->id)
            ->where('is_query', self::YES)
            ->get(['column_name', 'column_comment', 'query_type'])->toArray();

        $phpContent = '';
        foreach ($columns as $column) {
            $phpContent .= $this->getSearchCode($column);
        }

        return $phpContent;
    }

    /**
     * 获取业务名称
     * @return string
     */
    public function getBusinessName(): string
    {
        return Str::studly(str_replace(env('DB_PREFIX'), '', $this->model->table_name));
    }


    /**
     * 设置代码内容
     * @param string $content
     */
    public function setCodeContent(string $content)
    {
        $this->codeContent = $content;
    }

    /**
     * 获取代码内容
     * @return string
     */
    public function getCodeContent(): string
    {
        return $this->codeContent;
    }

}
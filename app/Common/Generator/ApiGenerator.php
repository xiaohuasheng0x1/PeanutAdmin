<?php
/** @noinspection PhpExpressionResultUnusedInspection */
/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */


declare(strict_types=1);
namespace App\Common\Generator;

use App\Backend\Model\GenerateTables;
use App\Common\Exception\NormalStatusException;
use App\Common\Helper\Str;
use Hyperf\Utils\Filesystem\Filesystem;

/**
 * JS API文件生成
 * Class ApiGenerator
 * @package Peanut\Generator
 */
class ApiGenerator extends PaGenerator implements CodeGenerator
{
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
     * @return ApiGenerator
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function setGenInfo(GenerateTables $model): ApiGenerator
    {
        $this->model = $model;
        $this->filesystem = make(Filesystem::class);
        if (empty($model->menu_name)) {
            throw new NormalStatusException(t('setting.gen_code_edit'));
        }
        return $this->placeholderReplace();
    }

    /**
     * 生成代码
     */
    public function generator(): void
    {
        $filename = Str::camel(str_replace(env('DB_PREFIX'), '', $this->model->table_name));
        $this->filesystem->makeDirectory(BASE_PATH . "/runtime/generate/vue/src/api/backend/", 0755, true, true);
        $path = BASE_PATH . "/runtime/generate/vue/src/api/backend/{$filename}.js";
        $this->filesystem->put($path, $this->replace()->getCodeContent());
    }

    /**
     * 预览代码
     */
    public function preview(): string
    {
        return $this->replace()->getCodeContent();
    }

    /**
     * 获取模板地址
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return $this->getStubDir().'/Api/main.stub';
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
    protected function placeholderReplace(): ApiGenerator
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
            '{LOAD_API}',
            '{COMMENT}',
            '{BUSINESS_NAME}',
            '{REQUEST_ROUTE}',
        ];
    }

    /**
     * 获取要替换占位符的内容
     */
    protected function getReplaceContent(): array
    {
        return [
            $this->getLoadApi(),
            $this->getComment(),
            $this->getBusinessName(),
            $this->getRequestRoute(),
        ];
    }

    protected function getLoadApi(): string
    {
        $menus = $this->model->generate_menus ? explode(',', $this->model->generate_menus) : [];
        $ignoreMenus = ['realDelete', 'recovery'];

        array_unshift($menus, $this->model->type === 'single' ? 'singleList' : 'treeList');

        foreach ($ignoreMenus as $menu) {
            if (in_array($menu, $menus)) {
                unset($menus[array_search($menu, $menus)]);
            }
        }

        $jsCode = '';
        $path = $this->getStubDir() . '/Api/';
        foreach ($menus as $menu) {
            $content = $this->filesystem->sharedGet($path . $menu . '.stub');
            $jsCode .= $content;
        }

        return $jsCode;
    }

    /**
     * 获取控制器注释
     * @return string
     */
    protected function getComment(): string
    {
        return $this->getBusinessName(). ' API JS';
    }

    /**
     * 获取请求路由
     * @return string
     */
    protected function getRequestRoute(): string
    {
        return 'backend/' . $this->getShortBusinessName();
    }

    /**
     * 获取业务名称
     * @return string
     */
    protected function getBusinessName(): string
    {
        return $this->model->menu_name;
    }

    /**
     * 获取短业务名称
     * @return string
     */
    public function getShortBusinessName(): string
    {
        return str_replace(env('DB_PREFIX'), '', $this->model->table_name);
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
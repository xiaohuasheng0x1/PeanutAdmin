<?php


declare(strict_types=1);
namespace App\Common\Command\Creater;

use Hyperf\Command\Annotation\Command;
use Hyperf\Utils\Filesystem\FileNotFoundException;
use Hyperf\Utils\Filesystem\Filesystem;
use App\Common\PaCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class CreateFormRequest
 * @package System\Command\Creater
 */
#[Command]
class CreateFormRequest extends PaCommand
{
    protected ?string $name = 'pa:request-gen';

    protected string $module;

    public function configure()
    {
        parent::configure();
        $this->setHelp('run "php bin/hyperf.php pa:module <name>"');
        $this->setDescription('Generate validate form request class file');

        $this->addArgument(
            'name', InputArgument::REQUIRED,
            'input FormRequest class file name'
        );
    }

    public function handle()
    {
        $this->module = ucfirst(trim($this->input->getArgument('module_name')));
        $this->name = ucfirst(trim($this->input->getArgument('name')));

        $fs = new Filesystem();

        try {
            $content = str_replace(
                ['{CLASS_NAME}'],
                [$this->name],
                $fs->get($this->getStub('form_request'))
            );
        } catch (FileNotFoundException $e) {
            $this->error($e->getMessage());
            exit;
        }

        $fs->put($this->getModulePath() . $this->name . 'FormRequest.php', $content);

        $this->info("<info>[INFO] Created request:</info> ". $this->name . 'FormRequest.php');
    }
}

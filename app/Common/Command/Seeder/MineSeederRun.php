<?php


declare(strict_types=1);
namespace App\Common\Command\Seeder;

use Hyperf\Command\Annotation\Command;
use Hyperf\Command\ConfirmableTrait;
use Hyperf\Database\Commands\Seeders\BaseCommand;
use Hyperf\Database\Seeders\Seed;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MineSeederRun
 * @package System\Command\Seeder
 */
#[Command]
class MineSeederRun extends BaseCommand
{
    use ConfirmableTrait;

    /**
     * The console command name.
     *
     * @var string|null
     */
    protected ?string $name = 'pa:seeder-run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected string $description = 'Seed the database with records';

    /**
     * The seed instance.
     *
     * @var Seed
     */
    protected Seed $seed;

    protected string $module;

    /**
     * Create a new seed command instance.
     * @param Seed $seed
     */
    public function __construct(Seed $seed)
    {
        parent::__construct();

        $this->seed = $seed;

        $this->setDescription('The run seeder class of PeanutAdmin module');
    }

    /**
     * Handle the current command.
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->seed->setOutput($this->output);

        if ($this->input->hasOption('database') && $this->input->getOption('database')) {
            $this->seed->setConnection($this->input->getOption('database'));
        }

        $this->seed->run([$this->getSeederPath()]);
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'Please enter the module to be run'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['path', null, InputOption::VALUE_OPTIONAL, 'The location where the seeders file stored'],
            ['realpath', null, InputOption::VALUE_NONE, 'Indicate any provided seeder file paths are pre-resolved absolute paths'],
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production'],
        ];
    }


    protected function getSeederPath(): string
    {
        if (! is_null($targetPath = $this->input->getOption('path'))) {
            return ! $this->usingRealPath()
                ? BASE_PATH . '/' . $targetPath
                : $targetPath;
        }

        return BASE_PATH . '/database/Seeders';
    }
}

<?php


declare(strict_types=1);
namespace App\Common\Command\Seeder;

use Hyperf\Command\Annotation\Command;
use Hyperf\Database\Commands\Seeders\BaseCommand;
use Hyperf\Database\Seeders\SeederCreator;
use Hyperf\Utils\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MineSeeder
 * @package System\Command\Seeder
 */
#[Command]
class MineSeeder extends BaseCommand
{
    /**
     * The seeder creator instance.
     *
     * @var SeederCreator
     */
    protected SeederCreator $creator;

    protected string $module;

    /**
     * Create a new seeder generator command instance.
     * @param SeederCreator $creator
     */
    public function __construct(SeederCreator $creator)
    {
        parent::__construct('pa:seeder-gen');
        $this->setDescription('Generate a new PeanutAdmin module seeder class');

        $this->creator = $creator;
    }

    /**
     * Handle the current command.
     */
    public function handle()
    {
        $name = Str::snake(trim($this->input->getArgument('name')));
        $this->writeMigration($name);
    }

    /**
     * Write the seeder file to disk.
     * @param string $name
     */
    protected function writeMigration(string $name)
    {
        $path = $this->ensureSeederDirectoryAlreadyExist(
            $this->getSeederPath()
        );

        $file = pathinfo($this->creator->create($name, $path), PATHINFO_FILENAME);

        $this->info("<info>[INFO] Created Seeder:</info> {$file}");
    }

    protected function ensureSeederDirectoryAlreadyExist(string $path): string
    {
        if (! file_exists($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the seeder'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            ['path', null, InputOption::VALUE_OPTIONAL, 'The location where the seeder file should be created'],
            ['realpath', null, InputOption::VALUE_NONE, 'Indicate any provided seeder file paths are pre-resolved absolute paths'],
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

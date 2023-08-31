<?php
declare(strict_types=1);

namespace App\Common\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Database\Seeders\Seed;
use Hyperf\Database\Migrations\Migrator;
use App\Common\PaCommand;
use App\Common\Peanut;

/**
 * Class UpdateProjectCommand
 * @package System\Command
 */
#[Command]
class UpdateProjectCommand extends PaCommand
{
    /**
     * 更新项目命令
     * @var string|null
     */
    protected ?string $name = 'pa:update';

    protected array $database = [];

    protected Seed $seed;

    protected Migrator $migrator;

    /**
     * UpdateProjectCommand constructor.
     * @param Migrator $migrator
     * @param Seed $seed
     */
    public function __construct(Migrator $migrator, Seed $seed)
    {
        parent::__construct();
        $this->migrator = $migrator;
        $this->seed = $seed;
    }

    public function configure()
    {
        parent::configure();
        $this->setHelp('run "php bin/hyperf.php pa:update" Update PeanutAdmin system');
        $this->setDescription('PeanutAdmin system update command');
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $this->migrator->setConnection('default');

        $seedPath = BASE_PATH . '/database/Seeders/Update';
        $migratePath = BASE_PATH . '/database/Migrations/Update';

        if (is_dir($migratePath)) {
            $this->migrator->run([$migratePath]);
        }

        if (is_dir($seedPath)) {
            $this->seed->run([$seedPath]);
        }

        redis()->flushDB();

        $this->line($this->getGreenText('updated successfully...'));
    }
}

<?php

declare(strict_types = 1);
namespace App\Common\Command\Creater;

use Hyperf\DbConnection\Db;
use App\Common\PaCommand;
use Hyperf\Command\Annotation\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CreateModel
 */
#[Command]
class CreateModel extends PaCommand
{
    protected ?string $name = 'pa:model-gen';

    public function configure()
    {
        parent::configure();
        $this->setHelp('run "php bin/hyperf.php pa:model-gen [--table | -T [table]]"');
        $this->setDescription('Generate model to backend according to data table');
    }

    public function handle()
    {
        $table  = $this->input->getOption('table');
        if ($table) {
            $table = env('DB_PREFIX') . trim($this->input->getOption('table'));
        }

        $path = "app/Backend/Model";

        $db = env('DB_DATABASE');
        $prefix = env('DB_PREFIX');

        $tables = Db::select('SHOW TABLES');
        $key = "Tables_in_{$db}";

        $tableList = [];
        foreach ($tables as $k) {
            $tmp = $k->$key;
            if (!empty($prefix) && preg_match(sprintf("/%s_[_a-zA-Z0-9]+/i", $prefix), $tmp)) {
                $tableList[] = $tmp;
            }
            if (preg_match("/(\b|_[a-zA-Z0-9]+)/i", $tmp)) {
                $tableList[] = $tmp;
            }
        }

        if (!empty($table)) {
            $this->call('gen:model', ['table' => $table, '--path' => $path]);
        } else {
            foreach ($tableList as $table) {
                $this->call('gen:model', ['table' => $table, '--path' => $path]);
            }
        }
    }

    protected function getOptions(): array
    {
        return [
            ['table', '-T', InputOption::VALUE_OPTIONAL, 'Which table you want to associated with the Model.']
        ];
    }
}
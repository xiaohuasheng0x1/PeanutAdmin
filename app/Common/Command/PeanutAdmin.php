<?php


declare(strict_types=1);
namespace App\Common\Command;

use Hyperf\Command\Annotation\Command;
use App\Common\PaCommand;

/**
 * Class PeanutAdmin
 * @package System\Command
 */
#[Command]
class PeanutAdmin extends PaCommand
{
    protected ?string $name = 'pa';

    public function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub
    }

    /**
     * Handle the current command.
     */
    public function handle()
    {
        $result = shell_exec('php ' . BASE_PATH . '/bin/hyperf.php | grep pa');
        $this->line($this->getInfo(), 'comment');
        $this->line(preg_replace('/\s+Commons+/', '', $result), 'info');
    }
}
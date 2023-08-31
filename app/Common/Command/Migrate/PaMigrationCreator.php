<?php


declare(strict_types = 1);
namespace App\Common\Command\Migrate;

use Hyperf\Database\Migrations\MigrationCreator;

class PaMigrationCreator extends MigrationCreator
{

    public function stubPath(): string
    {
        return BASE_PATH . '/app/Common/Command/Migrate/Stubs';
    }
}

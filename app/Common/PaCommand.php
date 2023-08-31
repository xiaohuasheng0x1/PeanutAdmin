<?php


declare(strict_types=1);
namespace App\Common;

use Hyperf\Command\Command as HyperfCommand;

/**
 * Class PaCommand
 * @package System
 */
abstract class PaCommand extends HyperfCommand
{
    protected string $module;

    protected CONST CONSOLE_GREEN_BEGIN = "\033[32;5;1m";
    protected CONST CONSOLE_RED_BEGIN = "\033[31;5;1m";
    protected CONST CONSOLE_END = "\033[0m";

    protected function getGreenText($text): string
    {
        return self::CONSOLE_GREEN_BEGIN . $text . self::CONSOLE_END;
    }

    protected function getRedText($text): string
    {
        return self::CONSOLE_RED_BEGIN . $text . self::CONSOLE_END;
    }

    protected function getStub($filename): string
    {
        return BASE_PATH . '/app/Common/Command/Creater/Stubs/' . $filename . '.stub';
    }

    protected function getModulePath(): string
    {
        return BASE_PATH . '/app/Backend/Request/';
    }

    protected function getInfo(): string
    {
        return 'welcome to use peanutAdmin';
    }
}

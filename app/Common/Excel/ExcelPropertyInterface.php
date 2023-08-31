<?php
declare(strict_types=1);



namespace App\Common\Excel;

interface ExcelPropertyInterface
{
    public function import(\App\Common\PaModel $model, ?\Closure $closure = null): bool;

    public function export(string $filename, array|\Closure $closure): \Psr\Http\Message\ResponseInterface;
}
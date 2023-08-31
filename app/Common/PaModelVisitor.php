<?php
declare(strict_types=1);
namespace App\Common;

use Hyperf\Database\Commands\Ast\ModelUpdateVisitor;
use Hyperf\Utils\Str;

/**
 * Class PaModelVisitor
 * @package System
 */
class PaModelVisitor extends ModelUpdateVisitor
{
    /**
     * @param string $type
     * @return string|null
     */
    protected function formatDatabaseType(string $type): ?string
    {
        return match ($type) {
            'tinyint', 'smallint', 'mediumint', 'int', 'bigint' => 'integer',
            'decimal' => 'decimal:2',
            'float', 'double', 'real' => 'float',
            'bool', 'boolean' => 'boolean',
            'json' => 'array',
            default => null,
        };
    }

    /**
     * @param string $type
     * @param string|null $cast
     * @return string|null
     */
    protected function formatPropertyType(string $type, ?string $cast): ?string
    {
        if (! isset($cast)) {
            $cast = $this->formatDatabaseType($type) ?? 'string';
        }

        switch ($cast) {
            case 'integer':
                return 'int';
            case 'date':
            case 'datetime':
                return '\Carbon\Carbon';
            case 'json':
                return 'array';
        }

        if (Str::startsWith($cast, 'decimal')) {
            // 如果 cast 为 decimal，则 @property 改为 string
            return 'string';
        }

        return $cast;
    }
}
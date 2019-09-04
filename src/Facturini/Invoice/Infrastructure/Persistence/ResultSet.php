<?php
/**
 * This software was built by:
 * Daniel Tomé Fernández <danieltomefer@gmail.com>
 * GitHub: danitome24
 */
declare(strict_types=1);

namespace Facturini\Invoice\Infrastructure\Persistence;

interface ResultSet
{
    public function numberOfResults(): int;

    public function inArray(): ?array;
}

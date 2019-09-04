<?php
/**
 * This software was built by:
 * Daniel Tomé Fernández <danieltomefer@gmail.com>
 * GitHub: danitome24
 */

namespace Facturini\Invoice\Infrastructure\Persistence;

interface Query
{
    public function query($query);
}

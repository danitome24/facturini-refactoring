<?php
/**
 * This software was built by:
 * Daniel Tomé Fernández <danieltomefer@gmail.com>
 * GitHub: danitome24
 */

namespace Facturini\Invoice\Infrastructure\Persistence;

interface Connection
{
    public static function create($host, $user, $password, $db): self;

    public function connection();

    public function disconnect();
}

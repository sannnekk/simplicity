<?php

declare(strict_types=1);

namespace Simplicity\Core\Migration\Utils;

abstract class Migration
{
    public function run()
    {
        $this->up();
    }

    public function rollback()
    {
        $this->down();
    }

    abstract public function up();
    abstract public function down();
    abstract public function getTimestamp();
}

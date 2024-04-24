<?php

declare(strict_types=1);

namespace Simplicity\Core\Migration;

use Simplicity\Core\Migration\Utils\Migration;

class AddDefaultThemeMigration extends Migration
{
    public function getTimestamp(): int
    {
        return 1713884335;
    }

    public function up()
    {
        $exists = \RedBeanPHP\R::findOne('theme', 'name = ?', ['default']) !== null;

        if ($exists) {
            return;
        }

        $theme = \RedBeanPHP\R::dispense('theme');

        $theme->name = 'Simplicity default theme';
        $theme->path = 'Simplicity';
        $theme->active = 1;

        \RedBeanPHP\R::store($theme);
    }

    public function down()
    {
        $theme = \RedBeanPHP\R::findOne('theme', 'name = ?', ['default']);
        \RedBeanPHP\R::trash($theme);
    }
}

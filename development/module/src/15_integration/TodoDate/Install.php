<?php

namespace TodoDate;

use Queryflatfile\TableBuilder;

class Install
{
    public function install($container)
    {
        if (!$container->schema()->hasColumn('todo', 'date')) {
            $container->schema()->alterTable('todo', function (TableBuilder $table) {
                $table->date('date')->nullable();
            });
        }
    }

    public function uninstall($container)
    {
        if ($container->schema()->hasColumn('todo', 'date')) {
            $container->schema()->alterTable('todo', function (TableBuilder $table) {
                $table->dropColumn('date');
            });
        }
    }
}

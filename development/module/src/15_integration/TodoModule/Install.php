<?php

namespace TodoModule;

use Queryflatfile\TableBuilder;

class Install
{
    public function install($container)
    {
        $container->schema()->createTableIfNotExists('todo', function (TableBuilder $table) {
            $table->increments('id')
                ->string('title')
                ->integer('height')->valueDefault(1)
                ->boolean('achieve')->valueDefault(false);
        });

        $container->query()->insertInto('todo', [ 'title', 'height', 'achieve' ])
                ->values([ 'Item 1', 1, false ])
                ->values([ 'Item 2', 2, false ])
                ->values([ 'Item 3', 3, false ])
                ->execute();

        if ($container->schema()->hasTable('user')) {
            $container->query()->insertInto('permission', [
                    'permission_id', 'permission_label'
                ])
                ->values([ 'todo.index', 'Voir la liste des tâches' ])
                ->values([ 'todo.admin', 'Voir l’administration des tâches' ])
                ->values([ 'todo.item.create', 'Voir l’ajout des tâches' ])
                ->values([ 'todo.item.store', 'Ajouter des tâches' ])
                ->values([ 'todo.item.edit', 'Voir l’édition des tâches' ])
                ->values([ 'todo.item.update', 'Éditer les tâches' ])
                ->values([ 'todo.item.delete', 'Supprimer les tâches' ])
                ->execute();

            $container->query()->insertInto('role_permission', [
                    'role_id', 'permission_id'
                ])
                ->values([ 1, 'todo.index' ])
                ->values([ 2, 'todo.index' ])
                ->values([ 3, 'todo.index' ])
                ->values([ 3, 'todo.admin' ])
                ->values([ 3, 'todo.item.create' ])
                ->values([ 3, 'todo.item.store' ])
                ->values([ 3, 'todo.item.edit' ])
                ->values([ 3, 'todo.item.update' ])
                ->values([ 3, 'todo.item.delete' ])
                ->execute();
        }
        if ($container->schema()->hasTable('menu')) {
            $container->query()->insertInto('menu_link', [ 'key', 'title_link', 'link',
                    'menu', 'weight', 'parent' ])
                ->values([
                    'todo.admin',
                    '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Todo',
                    'admin/todo',
                    'admin-menu',
                    7,
                    -1
                ])
                ->values([
                    'todo.index',
                    'Todo',
                    'todo/index',
                    'main-menu',
                    5,
                    -1
                ])
                ->execute();
        }
    }

    public function uninstall($container)
    {
        if ($container->schema()->hasTable('user')) {
            $container->query()
                ->from('permission')
                ->delete()
                ->where('permission_id', 'like', 'todo%')
                ->execute();

            $container->query()
                ->from('role_permission')
                ->delete()
                ->where('permission_id', 'like', 'todo%')
                ->execute();
        }

        if ($container->schema()->hasTable('menu')) {
            $container->query()
                ->from('menu_link')
                ->delete()
                ->where('link', 'admin/todo')
                ->orWhere('link', 'todo/index')
                ->execute();
        }

        $container->schema()->dropTable('todo');
    }
}

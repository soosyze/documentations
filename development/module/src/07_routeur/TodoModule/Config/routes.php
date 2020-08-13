<?php

use Soosyze\Components\Router\Route as R;

R::useNamespace('SoosyzeExtension\TodoModule\Controller');

R::get('todo.index',   'todo/index',                 'TodoController@index');
R::get('todo.admin',   'admin/todo',                 'TodoController@admin');
R::get('todo.create',  'admin/todo/item',            'TodoController@create');
R::post('todo.store',  'admin/todo/item',            'TodoController@store');
R::get('todo.edit',    'admin/todo/item/:id/edit',   'TodoController@edit',   [':id' => '\d+']);
R::post('todo.update', 'admin/todo/item/:id/edit',   'TodoController@update', [':id' => '\d+']);
R::post('todo.delete', 'admin/todo/item/:id/delete', 'TodoController@delete', [':id' => '\d+']);
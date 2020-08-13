<?php

use Soosyze\Components\Router\Route as R;

R::useNamespace('SoosyzeExtension\TodoModule\Controller');

R::get('todo.index', 'todo/index', 'TodoController@index');
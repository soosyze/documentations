<?php

// modules/TodoModule/Services/Todo.php

namespace TodoModule\Services;

class Todo
{
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function getList()
    {
        return $this->query
                ->select()
                ->from('todo')
                ->orderBy('height')
                ->fetchAll();
    }

    public function getItem($id)
    {
        return $this->query
                ->select()
                ->from('todo')
                ->where('id', '==', $id)
                ->fetch();
    }
}

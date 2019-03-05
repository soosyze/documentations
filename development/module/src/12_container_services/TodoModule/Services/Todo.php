<?php

// modules/TodoModule/Services/Todo.php

namespace TodoModule\Services;

class Todo
{
    public function getList()
    {
        return [
            1 => [
                'id'      => 1,
                'title'   => 'Item 1',
                'height'  => 1,
                'achieve' => false,
            ],
            2 => [
                'id'      => 2,
                'title'   => 'Item 2',
                'height'  => 2,
                'achieve' => false,
            ],
            3 => [
                'id'      => 3,
                'title'   => 'Item 3',
                'height'  => 3,
                'achieve' => false,
            ],
        ];
    }

    public function getItem($id)
    {
        $data = $this->getList();

        return isset($data[ $id ])
            ? $data[ $id ]
            : [];
    }
}

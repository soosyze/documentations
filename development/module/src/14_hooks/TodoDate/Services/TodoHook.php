<?php

namespace TodoDate\Services;

class TodoHook
{
    private $query;

    private $schema;

    public function __construct($query, $schema)
    {
        $this->query  = $query;
        $this->schema = $schema;
    }

    public function hookCreateFormData(&$data)
    {
        if ($this->schema->hasTable('todo')) {
            $data[ 'date' ] = '';
        }
    }

    public function hookEditFormData(&$data, $id)
    {
        if ($this->schema->hasTable('todo')) {
            if (!empty($data[ 'date' ])) {
                $data[ 'date' ] = $data[ 'date' ];
            }
        }
    }

    public function hookCreateForm(&$form, $data)
    {
        if ($this->schema->hasTable('todo')) {
            $form->addBefore('submit', function ($form) use ($data) {
                $form->group('todo-item-date-group', 'div', function ($form) use ($data) {
                    $form->label('todo-item-date-label', 'Date butoire', [ 'for' => 'todo-item-date' ])
                        ->date('date', 'todo-item-date', [
                            'class' => 'form-control',
                            'value' => $data[ 'date' ]
                    ]);
                }, [ 'class' => 'form-group' ]);
            });
        }
    }

    public function hookStoreValidator(&$validator)
    {
        if ($this->schema->hasTable('todo')) {
            $minDate = date('Y-m-d', time());
            $validator->addRule('date', '!required|date_before_or_equal:' . $minDate);
        }
    }

    public function hookStoreAfter($validator, &$value)
    {
        if ($this->schema->hasTable('todo')) {
            if (!empty($validator->getInput('date'))) {
                $value[ 'date' ] = $validator->getInput('date');
            }
        }
    }

    public function hookUpdateAfter($validator, &$value, $id)
    {
        if ($this->schema->hasTable('todo')) {
            $value[ 'date' ] = $validator->getInput('date');
        }
    }
}

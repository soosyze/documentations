<?php

namespace TodoDate\Controller;

class TodoDateController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathServices = MODULES_CONTRIBUED . 'TodoDate' . DS . 'Config' . DS . 'service.json';
    }
}

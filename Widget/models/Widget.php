<?php

namespace Widget\models;

use System\Model;

class Widget extends Model
{
    public function render($view)
    {
        $viewFile = dirname(dirname(__FILE__)).DS.'views'.DS.$view.'.php';
        ob_start();
        $html = ob_get_clean();
        return $html;
    }
}

<?php

namespace Widget\models;

use System\Model;

class Widget extends Model
{
    protected $permittedColumns = array(
        'label',
        'code',
        'link',
    );

    public function render($view)
    {
        $viewFile = dirname(dirname(__FILE__)).DS.'views'.DS.$view.'.php';
        ob_start();
        require $viewFile;
        $html = ob_get_clean();
        return $html;
    }
}

<?php

namespace Widget\models;

use Core\Model;

class Widget extends Model
{
    protected $permittedColumns = array(
        'label',
        'type',
        'app_widget',
        'params'
    );

    public function setDefaultProperties()
    {
    	parent::setDefaultProperties();

    	$this->app_widget = 0;
	}
}

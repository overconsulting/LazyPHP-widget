<?php

namespace Widget\models;

use System\Model;

class Widget extends Model
{
    protected $permittedColumns = array(
        'label',
        'type',
        'link',
    );
}

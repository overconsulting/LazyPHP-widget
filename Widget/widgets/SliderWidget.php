<?php

namespace Widget\widgets;

use Widget\widgets\Widget;
use Widget\models\Slider;

class SliderWidget extends Widget
{
	public function __construct($params = array())
	{
		$this->type = 'slider';
		parent::__construct($params);
	}

    public static function getDbModel()
    {
        return 'Slider';
    }
}

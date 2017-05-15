<?php

namespace Widget\widgets;

use Widget\widgets\Widget;
use Widget\models\Slider;

class SliderWidget extends Widget
{
	public function __construct($params)
	{
		$this->type = 'slider';
	}
}

Widget::$classes['slider'] = 'Widget\widgets\SliderWidget';

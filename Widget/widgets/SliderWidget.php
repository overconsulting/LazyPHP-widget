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
}

Widget::addWidgetTypes(array(
    'slider' => array(
        'type' => 'slider',
        'class' => 'Widget\\widgets\\SliderWidget',
        'label' => 'Carrousel',
        'params' => array(
            'id' => array(
                'name' => 'id',
                'label' => 'Carrousel',
                'type' => 'table',
                'model' => 'Slider'
            )
        )
    )
));

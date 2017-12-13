<?php

namespace app\widgets;

use Widget\widgets\Widget;
use Core\Templator;

class ButtonWidget extends Widget
{
    public function __construct($params = array())
    {
        $this->type = 'button';
        parent::__construct($params);
    }

    public function getHtml()
    {
        $html = '';

        $url = isset($this->params['url']) ? ' url="'.$this->params['url'].'"' : '';
        $content = isset($this->params['text']) ? $this->params['text'] : '';
        
        $html = '{% button type="secondary" content="'.$content.'"'.$url.' class="widget-button" %}';

        $templator = new Templator();
        $html = $templator->parse($html);

        return $html;
    }
}

Widget::addWidgetType(array(
    'button' => array(
        'type' => 'button',
        'class' => 'app\\widgets\\ButtonWidget',
        'label' => 'Bouton',
        'params' => array(
            'url' => array(
                'name' => 'url',
                'label' => 'URL',
                'type' => 'string'
            ),
            'text' => array(
                'name' => 'text',
                'label' => 'Texte',
                'type' => 'string'
            )
        )
    )
));

<?php

namespace Widget\widgets;

class Widget
{
    public static $widgetTypes = array();

    public $type = '';

    public $params = array();

    public function __construct($params = array())
    {
        $this->params = $params;
    }

    public function getViewFile()
    {
        $viewFile = APP_DIR.DS.'widgets'.DS.'views'.DS.$this->type.'_widget.php';
        if (file_exists($viewFile)) {
            return $viewFile;
        }

        $viewFile = dirname(__FILE__).DS.'views'.DS.$thisis->type.'_widget.php';
        if (file_exists($viewFile)) {
            return $viewFile;
        }
    }

    public function getHtml()
    {
        return '<div class="widget widget-'.$this->type.'"></div>';
    }

    public static function addWidgetTypes($types) {
        self::$widgetTypes = array_merge(self::$widgetTypes, $types);
    }

    public static function addWidgetType($type) {
        self::$widgetTypes = array_merge(self::$widgetTypes, $type);
    }

    public static function getWidget($type, $params = array())
    {
        $class = self::$widgetTypes[$type];
        $widget = new $class($params);
        return $widget;
    }

    public static function getWidgetHtml($type, $params = array())
    {
        $class = self::getWidget($type, $params);
        $widget = new $class($params);
        return $widget->getHtml();
    }
}

Widget::addWidgetTypes(array(
    'gallery' => 'Widget\widgets\GalleryWidget',
    'slider' => 'Widget\widgets\SliderWidget'
));

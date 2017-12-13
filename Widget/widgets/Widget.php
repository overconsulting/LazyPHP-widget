<?php

namespace Widget\widgets;

class Widget
{
    public static $widgetTypes = array();

    public $type = '';

    public $params = array();

    public $controller = null;

    public function __construct($params = array())
    {
        $this->params = $params;
        $this->controller = isset($this->params['_controller']) ? $this->params['_controller'] : null;
    }

    public function getViewFile()
    {
        $viewFile = APP_DIR.DS.'widgets'.DS.'views'.DS.$this->type.'_widget.php';
        if (file_exists($viewFile)) {
            return $viewFile;
        }

        $viewFile = dirname(__FILE__).DS.'views'.DS.$this->type.'_widget.php';
        if (file_exists($viewFile)) {
            return $viewFile;
        }
    }

    public function getHtml()
    {
        return '<div class="widget widget-'.$this->type.'"></div>';
    }

    public static function addWidgetTypes($types)
    {
        self::$widgetTypes = array_merge(self::$widgetTypes, $types);
    }

    public static function addWidgetType($type)
    {
        self::$widgetTypes = array_merge(self::$widgetTypes, $type);
    }

    public static function getWidget($type, $params = array())
    {
        $class = self::$widgetTypes[$type]['class'];
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

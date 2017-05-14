<?php

namespace Widget;

use Widget\models\Gallery;
use Widget\models\Slider;

class Widget
{
    public static function getWidget($type, $id)
    {
        $html = '';

        switch ($type) {
            case 'gallery':
                $html = self::getWidgetGallery($id);
                break;

            case 'slider':
                $html = self::getWidgetSlider($id);
                break;

            case 'default':
                break;
        }

        return $html;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public static function getWidgetGallery($id)
    {
        $html = '';
        
        $gallery = Gallery::findById($id);
        $html = $gallery->render('gallery');
// var_dump($html);
        return $html;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public static function getWidgetSlider($id)
    {
        $html = '';

        $slider = Slider::findById($id);
        $html = $slider->render('slider');

        return $html;
    }
}

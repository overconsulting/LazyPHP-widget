<?php

namespace Widget\widgets;

use Widget\widgets\Widget;
use Widget\models\Gallery;
use System\Templator;

class GalleryWidget extends Widget
{
    public function __construct($params = array())
    {
        $this->type = 'gallery';
    }

    public function getHtml()
    {
        $html = '';

        $id = 0;
        if (!is_array($this->params)) {
            $id = (int)$params;
        } else if (isset($params['id'])) {
            $id = (int)$params['id'];
        }

        if ($id != 0) {
            $gallery = Gallery::findById($id);
            $viewFile = $this->getViewFile();
            ob_start();
            require $viewFile;
            $html = ob_get_clean();

            $templator = new Templator();
            $html = $templator->parse($html, array('gallery' => $gallery));
        }

        return $html;
    }
}

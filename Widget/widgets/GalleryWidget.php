<?php

namespace Widget\widgets;

use Widget\widgets\Widget;
use Widget\models\Gallery;
use Core\Templator;

class GalleryWidget extends Widget
{
    public function __construct($params = array())
    {
        $this->type = 'gallery';
        parent::__construct($params);
    }

    public function getHtml()
    {
        $html = '';

        $id = 0;
        if (isset($this->params['id'])) {
            $id = (int)$this->params['id'];
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

    public static function getDbModel()
    {
        return 'Widget\models\Gallery';
    }
}

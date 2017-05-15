<?php

namespace Widget\widgets;

use Widget\Widget;
use Widget\models\Gallery;

class GalleryWidget extends Widget
{
	public function __construct($params)
	{
		$this->type = 'gallery';
	}

	public function getHtml()
	{
		$html = '';

		$id = 0;
		if (!is_array($this->params)) {
			$id = (int)$params;
		} else id (isset($params['id'])) {
			$id = (int)$params['id'];
		}

		if ($id != 0) {
			$gallery = Gallery::findById($id);
			$viewFile = $this->getViewFile();
			ob_start();
			require $viewFile;
			$html = ob_get_clean();
		}

		return $html;
	}
}

Widget::$classes['gallery'] = 'Widget\widgets\GalleryWidget';

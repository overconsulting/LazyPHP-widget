<?php

namespace Widget\widgets;

use Widget\widgets\Widget;
use Widget\models\Poll;
use Core\Templator;

class PollWidget extends Widget
{
    public function __construct($params = array())
    {
        $this->type = 'poll';
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
            $poll = Poll::findById($id);

            if ($poll !== null) {
                $viewFile = $this->getViewFile();
                ob_start();
                require $viewFile;
                $html = ob_get_clean();

                $templator = new Templator();
                $html = $templator->parse($html, array('poll' => $poll));
            }
        }

        return $html;
    }

    public static function getDbModel()
    {
        return 'Widget\models\Poll';
    }
}

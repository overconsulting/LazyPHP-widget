<?php

namespace Widget\controllers;

use app\controllers\FrontController;

class WidgetsController extends FrontController
{
    public function renderAction()
    {
        $params = array(
            'error' => false,
            'message' => 0
        );

        $html = isset($this->request->post['html']) ? $this->request->post['html'] : '';

        $this->render($html, $params);
    }
}

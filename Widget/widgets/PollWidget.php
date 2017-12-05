<?php

namespace Widget\widgets;

use Widget\widgets\Widget;
use Widget\models\Poll;
use Widget\models\PollResult;
use Core\Templator;
use Helper\DatetimeUtils;

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

        $id = isset($this->params['id']) ? (int)$this->params['id'] : 0;

        $cockpit = isset($this->params['cockpit']) ? (bool)$this->params['cockpit'] : false;

        if ($id != 0) {
            $poll = Poll::findById($id);

            $currentUser = isset($this->controller->current_user) ? $this->controller->current_user : null;

            if ($currentUser !== null) {
                $isConnected = true;
                $pollResults = PollResult::findAll('user_id = '.$currentUser->id.' and poll_id = '.$poll->id);
                $hasAnswered = count($pollResults) > 0;
            } else {
                $isConnected = true;
                $hasAnswered = false;
            }

            $ds = DatetimeUtils::stringToTimestamp($poll->date_start);
            $de = DatetimeUtils::stringToTimestamp($poll->date_end);
            $showResults = time() > $de;

            $pollStats = $poll->getStats();

            if ($poll !== null) {
                $viewFile = $this->getViewFile();
                ob_start();
                require $viewFile;
                $html = ob_get_clean();

                $templator = new Templator();
                $html = $templator->parse(
                    $html,
                    array(
                        'poll' => $poll,
                        'cockpit' => $cockpit,
                        'isConnected' => $isConnected,
                        'hasAnswered' => $hasAnswered,
                        'pollStats' => $pollStats,
                        'showResults' => $showResults
                    )
                );
            }
        }

        return $html;
    }

    public static function getDbModel()
    {
        return 'Widget\models\Poll';
    }
}

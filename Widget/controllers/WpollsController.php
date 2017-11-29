<?php

namespace Widget\controllers;

use app\controllers\FrontController;
use Core\Router;
use Core\models\Site;
use Widget\models\Poll;
use Widget\models\PollResult;

class WpollsController extends FrontController
{
    public function sendAction()
    {
        $pollClass = $this->loadModel('Poll');
        $pollResultClass = $this->loadModel('PollResult');

        $params = array(
            'error' => false,
            'message' => ''
        );

        if ($this->current_user === null) {
            $params['error'] = true;
            $params['message'] = 'Vous devez être connecté pour répondre au sondage';
        } else {
            if (isset($this->request->post['poll_id']) && isset($this->request->post['answers'])) {
                $poll = $pollClass::findById($this->request->post['poll_id']);

                $answers = $this->request->post['answers'];
                foreach ($answers as $question_id => $answer)
                {
                    $pollResult = new $pollResultClass();
                    $pollResult->user_id = $this->current_user->id;
                    $pollResult->poll_id = $this->request->post['poll_id'];
                    $pollResult->question_id = $question_id;
                    $pollResult->answer = is_array($answer) ? implode(';', $answer) : $answer;
                    $pollResult->save();
                }
                $params['message'] = 'Merci pour votre participation';
                $params['poll_id'] = $poll->id;
            } else {
                $params['error'] = true;
                $params['message'] = 'Erreur(s) dans le formulaire';
            }
        }

        $this->render('', $params);
    }
}

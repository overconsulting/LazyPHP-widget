<?php

namespace Widget\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Router;
use Core\models\Site;
use Widget\models\Poll;
use Widget\models\PollQuestion;

class PollquestionsController extends CockpitController
{
    /**
     * @var string
     */
    private $pageTitle = '<i class="fa fa-bar-chart-o"></i> Gestion des sondages';

    /*
     * @var Widget\models\PollQuestion
     */
    public $pollQuestion = null;

    public function indexAction($pollId)
    {
        $this->redirect('cockpit_widget_polls_show_'.$pollId);
    }

    public function newAction($pollId)
    {
        if ($this->pollQuestion === null) {
            $this->pollQuestion = new PollQuestion();
            $this->pollQuestion->poll_id = $pollId;
            $this->pollQuestion->answers = array('', '');
        }

        $this->render(
            'widget::pollquestions::edit',
            array(
                'id' => 0,
                'pollQuestion' => $this->pollQuestion,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => '[Sondage n° '.$pollId.', '.$this->pollQuestion->poll->label.'] - Nouvelle question',
                'formAction' => Router::url('cockpit_widget_pollquestions_create_'.$pollId)
            )
        );
    }

    public function editAction($pollId, $id)
    {
        if ($this->pollQuestion === null) {
            $this->pollQuestion = PollQuestion::findById($id);
            $this->pollQuestion->answers = explode(';', $this->pollQuestion->answers);
        }

        $this->render(
            'widget::pollquestions::edit',
            array(
                'id' => 0,
                'pollQuestion' => $this->pollQuestion,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => '[Sondage n° '.$pollId.', '.$this->pollQuestion->poll->label.'] - Modification question',
                'formAction' => Router::url('cockpit_widget_pollquestions_update_'.$pollId.'_'.$id)
            )
        );
    }

    public function createAction($pollId)
    {
        $this->pollQuestion = new PollQuestion();
        $this->pollQuestion->poll_id = $pollId;

        if ($this->pollQuestion === null) {
            $this->pollQuestion = PollQuestion::findById($id);
        }

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if ($this->pollQuestion->save($this->request->post)) {
            $this->addFlash('Question ajoutée', 'success');
            $this->redirect('cockpit_widget_polls_edit_'.$pollId);
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction($pollId);
    }

    public function updateAction($pollId, $id)
    {
        $this->pollQuestion = PollQuestion::findById($id);

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if ($this->pollQuestion->save($this->request->post)) {
            $this->addFlash('Question modifiée', 'success');
            $this->redirect('cockpit_widget_polls_edit_'.$pollId);
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($pollId, $id);
    }

    public function deleteAction($pollId, $id)
    {
        $pollQuestion = PollQuestion::findById($id);
        $pollQuestion->delete();
        $this->addFlash('Question supprimée', 'success');
        $this->redirect('cockpit_widget_polls_edit_'.$pollId);
    }
}

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
            $this->poll_id = $pollId;
        }

        $this->render(
            'widget::pollquestions::edit',
            array(
                'id' => 0,
                'poll' => $this->pollQuestion->poll,
                'pollQuestion' => $this->pollQuestion,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Nouvelle question',
                'formAction' => Router::url('cockpit_widget_pollquestions_create_'.$pollId)
            )
        );
    }

    public function editAction($pollId, $id)
    {
        if ($this->pollQuestion === null) {
            $this->pollQuestion = PollQuestion::findById($id);
        }

        $this->render(
            'widget::pollquestions::edit',
            array(
                'id' => 0,
                'poll' => $this->pollQuestion->poll,
                'pollQuestion' => $this->pollQuestion,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Nouvelle question',
                'formAction' => Router::url('cockpit_widget_pollquestions_update_'.$pollId.'_'.$id)
            )
        );
    }

    public function createAction($pollId)
    {
        $this->poll = new Poll();
        $this->poll_id = $pollId;

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if ($this->poll->save($this->request->post)) {
            $this->addFlash('Sondage ajouté<br />Vous pouvez ajouter les questions', 'success');
            $this->redirect('cockpit_widget_polls_edit_'.$this->poll->id);
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction($pollId);
    }

    public function updateAction($pollId, $id)
    {
        $this->poll = Poll::findById($id);

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if ($this->poll->save($this->request->post)) {
            $this->addFlash('Sondage modifié', 'success');
            $this->redirect('cockpit_widget_polls');
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($pollId, $id);
    }

    public function deleteAction($id)
    {
        $poll = Poll::findById($id);
        $poll->delete();
        $this->addFlash('Sondage supprimé', 'success');
        $this->redirect('cockpit_widget_polls');
    }
}

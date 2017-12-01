<?php

namespace Widget\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Router;
use Core\models\Site;
use Widget\models\Poll;
use Widget\models\PollVote;
use Helper\Datetime;

class PollsController extends CockpitController
{
    /**
     * @var Widget\models\Poll
     */
    private $poll = null;

    /**
     * @var string
     */
    private $pageTitle = '<i class="fa fa-bar-chart-o"></i> Gestion des sondages';

    public function indexAction()
    {
        if ($this->site !== null) {
            $where = 'site_id = '.$this->site->id;
        } else {
            $where = '';
        }
        $polls = Poll::findAll($where);

        $this->render(
            'widget::polls::index',
            array(
                'polls' => $polls,
                'pageTitle' => $this->pageTitle,
                'boxTitle'  => 'Liste des sondages'
            )
        );
    }

    public function showAction($id)
    {
        if ($this->poll === null) {
            $this->poll = Poll::findById($id);
        }

        $ds = Datetime::stringToTimestamp($this->poll->date_start);
        $de = Datetime::stringToTimestamp($this->poll->date_end);
        $pollFinished = time() > $de;

        $participants = $this->poll->getParticipants();

        $this->render(
            'widget::polls::show',
            array(
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Sondage',
                'poll' => $this->poll,
                'pollFinished' => $pollFinished,
                'participants' => $participants
            )
        );
    }

    public function newAction()
    {
        if ($this->poll === null) {
            $this->poll = new Poll();
        }

        $siteOptions = Site::getOptions();

        $this->render(
            'widget::polls::edit',
            array(
                'id' => 0,
                'poll' => $this->poll,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Nouveau sondage',
                'formAction' => Router::url('cockpit_widget_polls_create'),
                'siteOptions' => $siteOptions,
                'selectSite' => $this->current_user->site_id === null
            )
        );
    }

    public function editAction($id)
    {
        if ($this->poll === null) {
            $this->poll = Poll::findById($id);
        }

        $siteOptions = Site::getOptions();

        $this->render(
            'widget::polls::edit',
            array(
                'id' => $id,
                'poll' => $this->poll,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Modification sondage',
                'formAction' => Router::url('cockpit_widget_polls_update_'.$id),
                'siteOptions' => $siteOptions,
                'selectSite' => $this->current_user->site_id === null
            )
        );
    }

    public function createAction()
    {
        $this->poll = new Poll();

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if ($this->poll->save($this->request->post)) {
            $this->addFlash('Sondage créé<br />Vous pouvez ajouter les questions', 'success');
            $this->redirect('cockpit_widget_polls_edit_'.$this->poll->id);
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
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

        $this->editAction($id);
    }

    public function deleteAction($id)
    {
        $poll = Poll::findById($id);
        $poll->delete();
        $this->addFlash('Sondage supprimé', 'success');
        $this->redirect('cockpit_widget_polls');
    }
}

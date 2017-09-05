<?php

namespace Widget\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Router;
use Core\Session;

use Widget\models\Gallery;
use Widget\models\GalleryMedia;

class GalleriesController extends CockpitController
{
    /**
     * @var string
     */
    private $pageTitle = '<i class="fa fa-picture-o fa-ciel"></i> Gestion des Galleries';

    /*
     * @var Widget\models\Gallery
     */
    public $gallery = null;

    public function indexAction()
    {
        $galleries = Gallery::findAll();

        $this->render('widget::galleries::index', array(
            'galleries' => $galleries,
            'pageTitle' => $this->pageTitle,
            'boxTitle'  => 'Liste des galleries'
        ));
    }

    public function newAction()
    {
        if ($this->gallery === null) {
            $this->gallery = new Gallery();
        }

        $this->render('widget::galleries::edit', array(
            'id' => 0,
            'gallery' => $this->gallery,
            'pageTitle' => $this->pageTitle,
            'boxTitle' => 'Nouvelle gallerie',
            'formAction' => Router::url('cockpit_widget_galleries_create')
        ));
    }

    public function editAction($id)
    {
        if ($this->gallery === null) {
            $this->gallery = Gallery::findById($id);
        }

        $this->render('widget::galleries::edit', array(
            'id' => $id,
            'gallery' => $this->gallery,
            'pageTitle' => $this->pageTitle,
            'boxTitle' => 'Modification gallerie n°'.$id,
            'formAction' => Router::url('cockpit_widget_galleries_update_'.$id)
        ));
    }

    public function createAction()
    {
        $this->gallery = new Gallery();

        $addedMedias = $this->request->post['added_medias'] != '' ? explode(',', $this->request->post['added_medias']) : array();

        if ($this->gallery->save($this->request->post)) {
            $this->addMedias($addedMedias);
            $this->addFlash('Gallerie ajoutée', 'success');
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
    {
        $this->gallery = Gallery::findById($id);

        $addedMedias = $this->request->post['added_medias'] != '' ? explode(',', $this->request->post['added_medias']) : array();

        if ($this->gallery->save($this->request->post)) {
            $this->addMedias($addedMedias);
            $this->addFlash('Gallerie modifiée', 'success');
            $this->redirect('cockpit_widget_galleries_edit_'.$this->gallery->id);
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($id);
    }

    public function deleteAction($id)
    {
        $gallery = Gallery::findById($id);
        $gallery->delete();
        $this->addFlash('Gallerie supprimée', 'success');
        $this->redirect('cockpit_widget_galleries');
    }

    private function addMedias($medias)
    {
        $count = count($this->gallery->galleriesmedias);
        foreach ($medias as $media_id) {
            echo $media_id.'<br />';
            $gm = new GalleryMedia();
            $gm->gallery_id = $this->gallery->id;
            $gm->media_id = $media_id;
            $gm->position = $count;
            $gm->save();
            $count++;
        }
    }
}

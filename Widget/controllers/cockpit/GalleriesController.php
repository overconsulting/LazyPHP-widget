<?php

namespace Widget\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Router;
use Core\Session;

use Widget\models\Gallery;
use Widget\models\GalleryMedia;

class GalleriesController extends CockpitController
{
    /*
     * @var Widget\models\Gallery
     */
    public $gallery = null;

    public function indexAction()
    {
        $galleries = Gallery::findAll();

        $this->render('index', array(
            'galleries' => $galleries,
            'titleBox'  => 'Liste des galleries',
            'titlePage' => '<i class="fa fa-picture-o fa-ciel"></i> Gestion des Galleries'
        ));
    }

    public function newAction()
    {
        if ($this->gallery === null) {
            $this->gallery = new Gallery();
        }

        $this->render('edit', array(
            'id' => 0,
            'gallery' => $this->gallery,
            'titleBox' => 'Nouvelle gallerie',
            'titlePage' => '<i class="fa fa-picture-o fa-ciel"></i> Gestion des Galleries',
            'formAction' => Router::url('cockpit_widget_galleries_create')
        ));
    }

    public function editAction($id)
    {
        if ($this->gallery === null) {
            $this->gallery = Gallery::findById($id);
        }

        $this->render('edit', array(
            'id' => $id,
            'gallery' => $this->gallery,
            'titleBox' => 'Modification gallerie n°'.$id,
            'titlePage' => '<i class="fa fa-picture-o fa-ciel"></i> Gestion des Galleries',
            'formAction' => Router::url('cockpit_widget_galleries_update_'.$id)
        ));
    }

    public function createAction()
    {
        $this->gallery = new Gallery();

        $addedMedias = $this->request->post['added_medias'] != '' ? explode(',', $this->request->post['added_medias']) : array();

        if ($this->gallery->save($this->request->post)) {
            $this->addMedias($addedMedias);
            Session::addFlash('Gallerie ajoutée', 'success');
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
    {
        $this->gallery = Gallery::findById($id);

        $addedMedias = $this->request->post['added_medias'] != '' ? explode(',', $this->request->post['added_medias']) : array();

        if ($this->gallery->save($this->request->post)) {
            $this->addMedias($addedMedias);
            Session::addFlash('Gallerie modifiée', 'success');
            $this->redirect('cockpit_widget_galleries_edit_'.$this->gallery->id);
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($id);
    }

    public function deleteAction($id)
    {
        $gallery = Gallery::findById($id);
        $gallery->delete();
        Session::addFlash('Gallerie supprimée', 'success');
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

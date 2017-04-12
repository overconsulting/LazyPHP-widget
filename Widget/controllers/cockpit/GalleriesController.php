<?php

namespace Widget\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use System\Router;
use System\Session;

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
            'pageTitle' => 'Galleries'
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
            'pageTitle' => 'Nouvelle gallerie',
            'formAction' => Router::url('cockpit_widget_galleries_create')
        ));
    }

    public function editAction($id)
    {
        if ($this->gallery === null) {
            $this->gallery = Gallery::findById($id);
        }

        $galleriesmedias = GalleryMedia::findAll('id = '.$this->gallery->id);

        $this->render('edit', array(
            'id' => $id,
            'gallery' => $this->gallery,
            'galleriesmedias' => $galleriesmedias,
            'pageTitle' => 'Modification gallerie n°'.$id,
            'formAction' => Router::url('cockpit_widget_galleries_update_'.$id)
        ));
    }

    public function createAction()
    {
        if (!isset($this->request->post['active'])) {
            $this->request->post['active'] = 0;
        }

        $this->gallery = new Gallery();
        $this->gallery->setData($this->request->post);

        if ($this->gallery->valid()) {
            if ($this->gallery->create((array)$this->gallery)) {
                Session::addFlash('Gallerie ajoutée', 'success');
                $this->redirect('cockpit_widget_galleries');
            } else {
                Session::addFlash('Erreur insertion base de données', 'danger');
            };
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
    {
        if (!isset($this->request->post['active'])) {
            $this->request->post['active'] = 0;
        }

        $this->gallery = Gallery::findById($id);
        $this->gallery->setData($this->request->post);

        if ($this->gallery->valid()) {
            if ($this->gallery->update((array)$this->gallery)) {
                Session::addFlash('Gallerie modifiée', 'success');
                $this->redirect('cockpit_widget_galleries');
            } else {
                Session::addFlash('Erreur mise à jour base de données', 'danger');
            }
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
}

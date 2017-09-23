<?php

namespace Widget\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Router;

use Widget\models\Gallery;
use Widget\models\GalleryMedia;

class GalleriesController extends CockpitController
{
    /**
     * @var Widget\models\Gallery
     */
    private $gallery = null;

    /**
     * @var string
     */
    private $pageTitle = '<i class="fa fa-picture-o fa-ciel"></i> Gestion des galleries';

    public function indexAction()
    {
        if ($this->site !== null) {
            $where = 'site_id = '.$this->site->id;
        } else {
            $where = '';
        }
        $galleries = Gallery::findAll($where);

        $this->render(
            'widget::galleries::index',
            array(
                'galleries' => $galleries,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Liste des galleries'
            )
        );
    }

    public function newAction()
    {
        if ($this->gallery === null) {
            $this->gallery = new Gallery();
        }

        $this->render(
            'widget::galleries::edit',
            array(
                'id' => 0,
                'gallery' => $this->gallery,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Nouvelle gallerie',
                'formAction' => Router::url('cockpit_widget_galleries_create')
            )
        );
    }

    public function editAction($id)
    {
        if ($this->gallery === null) {
            $this->gallery = Gallery::findById($id);
        }

        $this->render(
            'widget::galleries::edit',
            array(
                'id' => $id,
                'gallery' => $this->gallery,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Modification gallerie',
                'formAction' => Router::url('cockpit_widget_galleries_update_'.$id)
            )
        );
    }

    public function createAction()
    {
        $this->gallery = new Gallery();

        // $addedMedias = $this->request->post['added_medias'] != '' ? explode(',', $this->request->post['added_medias']) : array();

        if ($this->gallery->save($this->request->post)) {
            // $this->addMedias($addedMedias);
            $this->addFlash('Gallerie ajoutée', 'success');
            $this->addFlash('Vous pouvez maintenant ajouter des medias à la gallerie', 'info');
            $this->redirect('cockpit_widget_galleries_edit_'.$this->gallery->id);
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
        $galleriesmedias = $this->gallery->galleriesmedias;
        foreach ($galleriesmedias as $gallerymedia) {
            $gallerymedia->delete();
        }
        $gallery->delete();
        $this->addFlash('Gallerie supprimée', 'success');
        $this->redirect('cockpit_widget_galleries');
    }

    private function addMedias($medias)
    {
        $count = count(c);
        foreach ($medias as $media_id) {
            $gm = new GalleryMedia();
            $gm->gallery_id = $this->gallery->id;
            $gm->media_id = $media_id;
            $gm->position = $count;
            $gm->save();
            $count++;
        }
    }
}

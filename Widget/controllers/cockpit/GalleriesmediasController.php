<?php

namespace Widget\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use System\Router;
use System\Session;

use Widget\models\GalleryMedia;
use Widget\models\Gallery;
use Media\models\Media;

use Helper\Bootstrap;

class GalleriesmediasController extends CockpitController
{
    /*
     * @var Widget\models\GalleryMedia
     */
    public $galleryMedia = null;

    public function newAction($galleryId)
    {
        if ($this->galleryMedia === null) {
            $this->galleryMedia = new GalleryMedia();
            $this->galleryMedia->gallery_id = $galleryId;
        }

        $medias = Media::findAll();
        $mediaOptions = array();
        foreach ($medias as $media) {
            $mediaOptions[] = array(
                'value' => $media->id,
                'label' => '('.$media->id.') '.$media->title
            );
        }

        $this->render('edit', array(
            'id' => 0,
            'galleryMedia' => $this->galleryMedia,
            'galleryId' => $galleryId,
            'mediaOptions' => $mediaOptions,
            'pageTitle' => 'Ajout media à la gallerie',
            'formAction' => Router::url('cockpit_widget_galleriesmedias_create_'.$galleryId)
        ));
    }

    public function editAction($galleryId, $id)
    {
        if ($this->galleryMedia === null) {
            $this->galleryMedia = GalleryMedia::findById($id);
        }

        $this->galleryMedia = GalleryMedia::findById($id);

        $medias = Media::findAll();
        $mediaOptions = array();
        foreach ($medias as $media) {
            $mediaOptions[] = array(
                'value' => $media->id,
                'label' => '('.$media->id.') '.$media->title
            );
        }

        $this->render('edit', array(
            'id' => $id,
            'galleryMedia' => $this->galleryMedia,
            'galleryId' => $galleryId,
            'mediaOptions' => $mediaOptions,
            'pageTitle' => 'Modification media de la gallerie n°'.$galleryId,
            'formAction' => Router::url('cockpit_widget_galleriesmedias_update_'.$galleryId.'_'.$id)
        ));
    }

    public function createAction($galleryId)
    {
        if (!isset($this->request->post['active'])) {
            $this->request->post['active'] = 0;
        }

        $this->galleryMedia = new GalleryMedia();
        $this->galleryMedia->gallery_id = $galleryId;
        $this->galleryMedia->setData($this->request->post);

        if ($this->galleryMedia->valid()) {
            if ($this->galleryMedia->create((array)$this->galleryMedia)) {
                Session::addFlash('Media ajouté dans la gallerie', 'success');
                $this->redirect('cockpit_widget_galleries_edit_'.$galleryId);
            } else {
                Session::addFlash('Erreur insertion base de données', 'danger');
            };
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction($galleryId);
    }

    public function updateAction($galleryId, $id)
    {
        if (!isset($this->request->post['active'])) {
            $this->request->post['active'] = 0;
        }

        $this->galleryMedia = GalleryMedia::findById($id);
        $this->galleryMedia->setData($this->request->post);

        if ($this->galleryMedia->valid()) {
            if ($this->galleryMedia->update((array)$this->galleryMedia)) {
                Session::addFlash('Media de la gallerie modifié', 'success');
                $this->redirect('cockpit_widget_galleries_edit_'.$galleryId);
            } else {
                Session::addFlash('Erreur mise à jour base de données', 'danger');
            }
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($galleryId, $id);
    }

    public function deleteAction($galleryId, $id)
    {
        $gallerymedia = GalleryMedia::findById($id);
        $gallerymedia->delete();
        Session::addFlash('Media supprimé de la gallerie', 'success');
        $this->redirect('cockpit_widget_galleries_edit_'.$galleryId);
    }
}

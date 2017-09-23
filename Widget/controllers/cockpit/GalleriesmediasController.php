<?php

namespace Widget\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Router;

use Widget\models\GalleryMedia;
use Widget\models\Gallery;
use Media\models\Media;

use Helper\Bootstrap;

class GalleriesmediasController extends CockpitController
{
    /**
     * @var Widget\models\GalleryMedia
     */
    private $galleryMedia = null;

    /**
     * @var string
     */
    private $pageTitle = '<i class="fa fa-picture-o fa-ciel"></i> Gestion des medias de la gallerie';

    public function newAction($galleryId)
    {
        if ($this->galleryMedia === null) {
            $this->galleryMedia = new GalleryMedia();
            $this->galleryMedia->gallery_id = $galleryId;
        }

        $this->render(
            'widget::galleriesmedias::edit',
            array(
                'id' => 0,
                'galleryMedia' => $this->galleryMedia,
                'galleryId' => $galleryId,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Ajout media à la gallerie',
                'formAction' => Router::url('cockpit_widget_galleriesmedias_create_'.$galleryId)
            )
        );
    }

    public function editAction($galleryId, $id)
    {
        if ($this->galleryMedia === null) {
            $this->galleryMedia = GalleryMedia::findById($id);
        }

        $this->render(
            'widget::galleriesmedias::edit',
            array(
                'id' => $id,
                'galleryMedia' => $this->galleryMedia,
                'galleryId' => $galleryId,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Modification media de la gallerie',
                'formAction' => Router::url('cockpit_widget_galleriesmedias_update_'.$galleryId.'_'.$id)
            )
        );
    }

    public function createAction($galleryId)
    {
        $this->galleryMedia = new GalleryMedia();
        $this->galleryMedia->gallery_id = $galleryId;

        if ($this->galleryMedia->save($this->request->post)) {
            $this->addFlash('Media ajouté dans la gallerie', 'success');
            $this->redirect('cockpit_widget_galleries_edit_'.$galleryId);
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction($galleryId);
    }

    public function updateAction($galleryId, $id)
    {
        $this->galleryMedia = GalleryMedia::findById($id);
        
        if ($this->galleryMedia->save($this->request->post)) {
            $this->addFlash('Media de la gallerie modifié', 'success');
            $this->redirect('cockpit_widget_galleries_edit_'.$galleryId);
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($galleryId, $id);
    }

    public function deleteAction($galleryId, $id)
    {
        $gallerymedia = GalleryMedia::findById($id);
        $gallerymedia->delete();
        $this->addFlash('Media supprimé de la gallerie', 'success');
        $this->redirect('cockpit_widget_galleries_edit_'.$galleryId);
    }
}

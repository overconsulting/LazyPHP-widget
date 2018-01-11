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
        $galeryClass = $this->loadModel('Gallery');
        if ($this->gallery === null) {
            $this->gallery = new $galeryClass();
            $this->gallery->site_id = $this->site->id;
        }

        $siteClass = $this->loadModel('Site');
        $siteOptions = $siteClass::getOptions();

        $this->render(
            'widget::galleries::edit',
            array(
                'id' => 0,
                'gallery' => $this->gallery,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Nouvelle gallerie',
                'formAction' => Router::url('cockpit_widget_galleries_create'),
                'siteOptions' => $siteOptions,
                'selectSite' => $this->current_user->site_id === null
            )
        );
    }

    public function editAction($id)
    {
        $galeryClass = $this->loadModel('Gallery');
        if ($this->gallery === null) {
            $this->gallery = $galeryClass::findById($id);
        }

        $siteClass = $this->loadModel('Site');
        $siteOptions = $siteClass::getOptions();

        $this->render(
            'widget::galleries::edit',
            array(
                'id' => $id,
                'gallery' => $this->gallery,
                'pageTitle' => $this->pageTitle,
                'boxTitle' => 'Modification gallerie',
                'formAction' => Router::url('cockpit_widget_galleries_update_'.$id),
                'siteOptions' => $siteOptions,
                'selectSite' => $this->current_user->site_id === null
            )
        );
    }

    public function createAction()
    {
        $galeryClass = $this->loadModel('Gallery');
        if ($this->gallery === null) {
            $this->gallery = new $galeryClass();
        }

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if (!isset($this->request->post['in_phototheque'])) {
            $this->request->post['in_phototheque'] = 0;
        }

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
        $galeryClass = $this->loadModel('Gallery');
        if ($this->gallery === null) {
            $this->gallery = $galeryClass::findById($id);
        }

        if (!isset($this->request->post['site_id'])) {
            $this->request->post['site_id'] = $this->site->id;
        }

        if (!isset($this->request->post['in_phototheque'])) {
            $this->request->post['in_phototheque'] = 0;
        }

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
        $galeryClass = $this->loadModel('Gallery');
        $gallery = $galeryClass::findById($id);
        $gallery->delete();
        $this->addFlash('Gallerie supprimée', 'success');
        $this->redirect('cockpit_widget_galleries');
    }

    private function addMedias($medias)
    {
        $galeryMediaClass = $this->loadModel('GalleryMedia');
        $count = count($this->gallery->medias);        
        foreach ($medias as $media_id) {
            $gm = new $galeryMediaClass();
            $gm->gallery_id = $this->gallery->id;
            $gm->media_id = $media_id;
            $gm->position = $count;
            $gm->save();
            $count++;
        }
    }
}

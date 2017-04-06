<?php

namespace Widget\models;

use System\Model;
use Catalog\models\Media;

class GalleryMedia extends Widget
{
    protected $permittedColumns = array(
        'gallery_id',
        'media_id',
        'title',
        'description',
        'active'
    );

    /**
     * Get list of associed table(s)
     *
     * @return mixed
     */
    public function getAssociations()
    {
        return array(
            'medias' => array(
                'type' => '1',
                'model' => 'Catalog\\models\\Media',
                'key' => 'media_id'
            )
        );
    }
}

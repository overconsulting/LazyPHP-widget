<?php

namespace Widget\models;

use System\Model;

class GalleryMedia extends Widget
{
    protected $permittedColumns = array(
        'gallery_id',
        'media_id',
        'title',
        'description',
        'position',
        'active'
    );

    public static function getTableName()
    {
        return 'galleries_medias';
    }

    /**
     * Get list of associed table(s)
     *
     * @return mixed
     */
    public function getAssociations()
    {
        return array(
            'gallery' => array(
                'type' => '1',
                'model' => 'Widget\\models\\Gallery',
                'key' => 'gallery_id'
            ),
            'media' => array(
                'type' => '1',
                'model' => 'Catalog\\models\\Media',
                'key' => 'media_id'
            )
        );
    }

    public function getValidations()
    {
        $validations = parent::getValidations();

        $validations = array_merge($validations, array(
            'media_id' => array(
                'type' => 'required',
                'error' => 'Media obligatoire'
            )
        ));

        return $validations;
    }
}

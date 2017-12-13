<?php

namespace Widget\models;

use Core\Model;

class Gallery extends Model
{
    protected $permittedColumns = array(
        'site_id',
        'title',
        'description'
    );

    public static function getTableName()
    {
        return 'galleries';
    }

    /**
     * Get list of associed table(s)
     *
     * @return mixed
     */
    public function getAssociations()
    {
        return array(
            'site' => array(
                'type' => '1',
                'model' => 'Core\\models\\Site',
                'key' => 'site_id',
            ),
            'galleriesmedias' => array(
                'type' => '*',
                'model' => 'Widget\\models\\GalleryMedia',
                'key' => 'gallery_id'
            )
        );
    }

    public function getValidations()
    {
        return array_merge(
            parent::getValidations(),
            array(
                'title' => array(
                    'type' => 'required',
                    'error' => 'Titre obligatoire'
                )
            )
        );
    }

    public function getOptionLabel()
    {
        return $this->title;
    }    
}

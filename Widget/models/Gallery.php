<?php

namespace Widget\models;

use Core\Model;

class Gallery extends Model
{
    protected $permittedColumns = array(
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
            'galleriesmedias' => array(
                'type' => '*',
                'model' => 'Widget\\models\\GalleryMedia',
                'key' => 'gallery_id'
            )
        );
    }
}

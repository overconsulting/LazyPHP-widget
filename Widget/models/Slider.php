<?php

namespace Widget\models;

use Widget\models\Widget;

class Slider extends Widget
{
    protected $permittedColumns = array(
        'title',
        'description',
        'delay',
        'duration'
    );

    /**
     * Get list of associed table(s)
     *
     * @return mixed
     */
    public function getAssociations()
    {
        return array(
            'slidersmedias' => array(
                'type' => '*',
                'model' => 'Widget\\models\\SliderMedia',
                'key' => 'slider_id'
            )
        );
    }

    public function getValidations()
    {
        $validations = parent::getValidations();

        $validations = array_merge($validations, array(
            'delay' => array(
                'type' => 'int',
                'error' => 'Durée invalide'
            ),
            'duration' => array(
                'type' => 'int',
                'error' => 'Durée invalide'
            )
        ));

        return $validations;
    }
}

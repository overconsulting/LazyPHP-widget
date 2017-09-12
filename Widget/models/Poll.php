<?php

namespace Widget\models;

use Core\Model;

class Poll extends Model
{
    protected $permittedColumns = array(
        'site_id',
        'label',
        'date_start',
        'date_end',
        'active'
    );

    public function getAssociations()
    {
        return array_merge(
            parent::getAssociations(),
            array(
                'site' => array(
                    'type' => '1',
                    'model' => 'Core\\models\\Site',
                    'key' => 'site_id'
                ),
                'pollquestions' => array(
                    'type' => '*',
                    'model' => 'Widget\\models\\PollQuestion',
                    'key' => 'poll_id'
                )
            )
        );
    }

    public function getValidations()
    {
        return array_merge(
            parent::getValidations(),
            array(
                'label' => array(
                    'type' => 'required',
                    'error' => 'Nom obligatoire'
                ),
                'date_start' => array(
                    array(
                        'type' => 'required',
                        'error' => 'Date début obligatoire'
                    ),
                    array(
                        'type' => 'datetime',
                        'format' => 'Y-d-m H:i:s',
                        'error' => 'Date invalide'
                    )
                ),
                'date_end' => array(
                    'type' => 'required',
                    'error' => 'Date fin obligatoire'
                )
            )
        );
    }
}

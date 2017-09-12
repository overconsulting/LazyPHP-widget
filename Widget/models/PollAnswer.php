<?php

namespace Widget\models;

use Core\Model;

class PollAnswer extends Model
{
    protected $permittedColumns = array(
        'user_id',
        'question_id',
        'answer'
    );

    public function getAssociations()
    {
        return array_merge(
            parent::getAssociations(),
            array(
                'user' => array(
                    'type' => '1',
                    'model' => 'Auth\\models\\User',
                    'key' => 'user_id'
                ),
                'question' => array(
                    'type' => '1',
                    'model' => 'Widget\\models\\PollQuestion',
                    'key' => 'question_id'
                )
            )
        );
    }
}

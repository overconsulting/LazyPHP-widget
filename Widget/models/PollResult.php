<?php

namespace Widget\models;

use Core\Model;

class PollResult extends Model
{
    protected $permittedColumns = array(
        'user_id',
        'poll_id',
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
                'poll' => array(
                    'type' => '1',
                    'model' => 'Widget\\models\\Poll',
                    'key' => 'poll_id'
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

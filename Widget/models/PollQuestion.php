<?php

namespace Widget\models;

use Core\Model;

class PollQuestion extends Model
{
    protected $permittedColumns = array(
        'poll_id',
        'question',
        'answer0',
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'answer5',
        'answer6',
        'answer7',
        'multiple_answer'
    );

    public function getAssociations()
    {
        return array_merge(
            parent::getAssociations(),
            array(
                'poll' => array(
                    'type' => '1',
                    'model' => 'Widget\\models\\Poll',
                    'key' => 'poll_id'
                ),
                'answers' => array(
                    'type' => '*',
                    'model' => 'Widget\\models\\PollAnswer',
                    'key' => 'pollquestion_id'
                )
            )
        );
    }

    public function getValidations()
    {
        return array_merge(
            parent::getValidations(),
            array(
                'question' => array(
                    'type' => 'required',
                    'error' => 'Question obligatoire'
                )
            )
        );
    }

    public function valid()
    {
        $res = parent::valid();

        

        return empty($this->errors);
    }
}
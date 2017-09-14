<?php

namespace Widget\models;

use Core\Model;

class PollQuestion extends Model
{
    protected $permittedColumns = array(
        'poll_id',
        'question',
        'multiple_answer',
        'answers'
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

        for ($i = 0; $i < 8; $i++) {
            $property = 'answer'.$i;
            $this->$property = trim($this->$property);
        }

        if (!is_array($this->answers)) {
            $this->answers = explode(';', $this->answers);
        }

        if (count($this->answers) < 2 || $this->answers[0] == '' || $this->answers[1] == '') {
            $this->errors['answers'] = 'Deux réponses minimum par question';
        }

        $this->answers = implode(';', $this->answers);

        return empty($this->errors);
    }
}

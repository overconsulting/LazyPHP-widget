<?php

namespace Widget\models;

use Core\Model;
use Core\Utils;

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

        $answers = $this->answers;
        if (!is_array($answers)) {
            $answers = explode(';', $answers);
        }

        Utils::removeEmptyElements($answers);

        if (count($answers) < 2 || $answers[0] == '' || $answers[1] == '') {
            $this->errors['answers'] = 'Deux réponses minimum par question';
        }

        return empty($this->errors);
    }
}

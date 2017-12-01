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
                'questions' => array(
                    'type' => '*',
                    'model' => 'Widget\\models\\PollQuestion',
                    'key' => 'poll_id'
                ),
                'results' => array(
                    'type' => '*',
                    'model' => 'Widget\\models\\PollResult',
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
                    array(
                        'type' => 'required',
                        'error' => 'Date fin obligatoire'
                    ),
                    array(
                        'type' => 'datetime',
                        'format' => 'Y-d-m H:i:s',
                        'error' => 'Date invalide'
                    )
                )
            )
        );
    }

    public function getStats()
    {
        $stats = array();

        foreach ($this->results as $result) {
            $question = $result->question;
            $answerLabels = explode(';', $question->answers);
            $qId = $question->id;
            $rId = $result->answer;

            $resultLabels = array();
            $answers = explode(';', $result->answer);
            foreach ($answers as $a) {
                $resultLabels[] = $answerLabels[$a];
            }
            $resultLabel = implode(', ', $resultLabels);

            if (isset($stats[$qId])) {
                $k = false;
                for ($i = 0; $i < count($stats[$qId]['results']); $i++) {
                    if ($stats[$qId]['results'][$i]['id'] == $rId) {
                        $k = $i;
                        break;
                    }
                }

                if ($k !== false) {
                    $stats[$qId]['results'][$k]['resultValue'] = $stats[$qId]['results'][$k]['resultValue'] + 1;
                } else {
                    $stats[$qId]['results'][] = array(
                        'id' => $rId,
                        'resultLabel' => $resultLabel,
                        'resultValue' => 1
                    );
                }
            } else {
                $stats[$qId] = array(
                    'question' => $question->question,                    
                    'results' => array(
                        array(
                            'id' => $rId,
                            'resultLabel' => $resultLabel,
                            'resultValue' => 1
                        )
                    )

                );
            }
        }

        $bgColors = array('success', 'info', 'warning', 'danger');

        foreach ($stats as $qId => $x) {
            $max = 0;
            $count = count($stats[$qId]['results']);

            for ($i = 0; $i < $count; $i++) {
                if ($stats[$qId]['results'][$i]['resultValue'] > $max) {
                    $max = $stats[$qId]['results'][$i]['resultValue'];
                }

                for ($j = $i + 1; $j < $count - 1; $j++) {
                    if ($stats[$qId]['results'][$i]['resultValue'] < $stats[$qId]['results'][$j]['resultValue']) {
                        $a = $stats[$qId]['results'][$i];
                        $stats[$qId]['results'][$i] = $stats[$qId]['results'][$j];
                        $stats[$qId]['results'][$j] = $a;
                    }
                }
            }

            for ($i = 0; $i <  $count; $i++) {
                $stats[$qId]['results'][$i]['bgColor'] = isset($bgColors[$i]) ? $bgColors[$i] : '';
                $stats[$qId]['results'][$i]['percent'] = $stats[$qId]['results'][$i]['resultValue'] >= $max ? 100 : 100*$stats[$qId]['results'][$i]['resultValue'] / $max;
            }
        }

        return $stats;
    }

    public function getParticipants()
    {
        if ($this->site_id !== null) {
            $where = 'site_id = '.$this->site_id;
        } else {
            $where = '';
        }

        $userClass = $this->loadModel('User');
        $userCount = count($userClass::findAll($where));

        $participants = array();
        foreach ($this->results as $result) {
            if (!isset($participants[$result->user_id])) {
                $participants[$result->user_id] = $result->user_id;
            }
        }

        return array(
            'participantCount' => count($participants),
            'userCount' => $userCount
        );
    }
}

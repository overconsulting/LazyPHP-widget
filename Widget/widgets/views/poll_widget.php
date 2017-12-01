<div id="poll_widget_<?php echo $poll->id; ?>" class="widget widget-poll">
<?php if ($showResults || $cockpit): ?>
    <?php if (!$cockpit): ?>
        <h3 class="poll-title"><?php echo $poll->label != '' ? $poll->label : 'Sondage'; ?> - Résultats</h3>
    <?php endif; ?>
    <div class="poll-results">
        <?php foreach($pollStats as $pollStat): ?>
            <div class="poll-question">
                <div class="poll-question-question">
                    <?php echo $pollStat['question']; ?>
                </div>
                <?php foreach($pollStat['results'] as $result): ?>
                    <div class="poll-result">
                        <div class="poll-result-label">
                            <?php echo $result['resultLabel']; ?>
                        </div>
                        <div class="poll-result-value">
                            <?php echo $result['resultValue']; ?>
                        </div>
                        <div class="progress">
                            <div class="progress-bar<?php echo $result['bgColor'] != '' ? ' bg-'.$result['bgColor'] : ''; ?>" style="width: <?php echo $result['percent']; ?>%;">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <?php if (!$cockpit): ?>
        <h3 class="poll-title"><?php echo $poll->label != '' ? $poll->label : 'Sondage'; ?></h3>
    <?php endif; ?>
    <?php if ($isConnected): ?>
        <?php if ($hasAnswered): ?>
            <p>Résultats le : <?php echo $poll->formatDatetime($poll->date_end, '%d/%m/%Y %H:%M:%S'); ?></p>
            <!-- <div class="alert alert-info">Vous avez déjà répondu au sondage</div> -->
        <?php else: ?>
            <?php if (count($poll->questions) > 0): ?>
                {% form_open id="formPollUser" noBootstrapCol="1" %}
                    {% input_hidden name="poll_id" value="<?php echo $poll->id; ?>" %}
                    <div class="poll-questions">
                        <?php foreach($poll->questions as $question): ?>
<?php
$answerOptions = '['.$question->answers.']';

$inputType = $question->multiple_answer == 1 ? 'input_checkboxgroup' : 'input_radiogroup';

$input = '{% '.$inputType.' name="answers['.$question->id.']" options="'.$answerOptions.'" label="'.$question->question.'" %}';
?>                
                            <div class="poll-question">
                                <?php echo $input; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($isConnected && !$hasAnswered): ?>
                        {% input_submit id="form_poll_user_send" name="send" value="send" formId="formPollUser" class="btn-primary" icon="save" label="Envoyer" %}
                    <?php endif; ?>
                {% form_close %}
            <?php else: ?>
                <div class="alert alert-info">Sondage bientôt en ligne</div>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info">Vous devez être connecté pour participer au sondage</div>
    <?php endif; ?>
<?php endif; ?>
</div>

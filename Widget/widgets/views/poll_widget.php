<div id="poll_widget_<?php echo $poll->id; ?>" class="widget widget-poll">
<?php if ($showResults): ?>
    <h3 class="poll-title"><?php echo $poll->label != '' ? $poll->label : 'Sondage'; ?> - Résultats</h3>
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
    <h3 class="poll-title"><?php echo $poll->label != '' ? $poll->label : 'Sondage'; ?></h3>
    <?php if ($isConnected): ?>
        <?php if ($hasAnswered): ?>
            <div class="alert alert-info">Vous avez déjà répondu au sondage</div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info">Vous devez être connecté pour participer au sondage</div>
    <?php endif; ?>
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
<?php endif; ?>
</div>

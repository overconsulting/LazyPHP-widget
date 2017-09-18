<div id="poll_widget_<?php echo $poll->id; ?>" class="widget widget-poll">
    <h3><?php echo $poll->label != '' ? $poll->label : 'Sondage'; ?></h3>
<?php if ($isConnected && !$hasAnswered): ?>
    {% form_open id="formPollUser" noBootstrapCol="1" %}
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
        {% input_hidden name="poll_id" value="<?php echo $poll->id; ?>" %}
        {% input_submit id="form_poll_user_send" name="send" value="send" formId="formPollUser" class="btn-primary" icon="save" label="Envoyer" %}
    {% form_close %}
<?php else: ?>
    <div class="pol-results">
        <?php foreach($poll->results as $result): ?>
            <?php foreach($result->questions as $question): ?>
                <div class=""
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>

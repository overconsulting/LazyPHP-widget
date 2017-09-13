<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_widget_polls_edit_<?php echo $poll->id; ?>" type="secondary" icon="arrow-left" size="sm" hint="Retour" %}
        </div>
    </div>
    <div class="box-body"><?php var_dump($pollQuestion->errors); ?>
        {% form_open id="formPollQuestion" action="formAction" %}
            {% input_text name="question" model="pollQuestion.question" label="Question" %}
            {% input_checkbox name="multiple_answer" model="pollQuestion.multiple_answer" label="Réponses multiples" %}
<?php for ($i = 0; $i < 8; $i++): ?>
            {% input_text name="answer<?php echo $i; ?>" model="pollQuestion.answer<?php echo $i; ?>" label="Réponse <?php echo $i + 1; ?>" %}
<?php endfor; ?>
            {% input_submit name="submit" value="save" formId="formPollQuestion" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>

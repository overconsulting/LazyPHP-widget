<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_widget_polls_edit_<?php echo $pollQuestion->poll_id; ?>" type="secondary" icon="arrow-left" size="sm" hint="Retour" %}
        </div>
    </div>
    <div class="box-body">
        {% form_open id="formPollQuestion" action="formAction" %}
            {% input_text name="question" model="pollQuestion.question" label="Question" %}
            {% input_checkbox name="multiple_answer" model="pollQuestion.multiple_answer" label="Réponses multiples" %}
            <div class="form-group row">
                <label class="col-form-label col-form-label-sm col-sm-2">Réponses</label>
                <div class="col-sm-10">
<?php
for ($i = 0; $i < count($pollQuestion->answers); $i++) {
    echo 
        '<div class="input-group">'.
            '<input id="answer'.$i.'" name="answer[]" value="" class="form-control form-control-sm" placeholder="" type="text" />'.
            '<span class="input-group-btn">'.
                '{% button type="danger" size="sm" icon="remove" hint="Supprimer la réponse" class="pollquestion-del-answer" data-answer="'.$i.'" %}'.
            '</span>'.
        '</div>';
}
        
?>
                    {% button type="success" size="sm" icon="plus" hint="Ajouter une réponse" class="pollquestion-add-answer" %}
                </div>
            </div>
            {% input_submit name="submit" value="save" formId="formPollQuestion" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>

<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-poll">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_widget_polls" type="secondary" icon="arrow-left" size="sm" hint="Retour" %}
        </div>
    </div>
    <div class="box-body">
        {% form_open id="formPoll" action="formAction" %}
<?php if ($selectSite): ?>
            {% input_select name="site_id" model="poll.site_id" label="Site" options="siteOptions" %}
<?php endif; ?>
            {% input_text name="label" model="poll.label" label="Nom" %}
            {% input_datetime name="date_start" model="poll.date_start" label="Date de début" %}
            {% input_datetime name="date_end" model="poll.date_end" label="Date de fin" %}
            {% input_submit name="submit" value="save" formId="formPoll" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>

<?php if (isset($poll->id)): ?>
<div class="box box-poll">
    <div class="box-header">
        <h3 class="box-title">Questions</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_widget_pollquestions_new_<?php echo $poll->id; ?>" type="success" size="sm" icon="plus" hint="Ajouter une question" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Réponses multiples</th>
                    <th>Réponses</th>
                    <th width="20%">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
$pollQuestions = $poll->questions;
if ($pollQuestions !== null && count($pollQuestions) > 0) {
    foreach ($poll->questions as $pollQuestion) {
        if ($pollQuestion->multiple_answer == 1) {
            $multipleAnswer = '<i class="fa fa-check text-success"></i>';
        } else {
            $multipleAnswer = '<i class="fa fa-remove text-danger"></i>';
        }

        $answers = explode(';', $pollQuestion->answers);

        echo
            '<tr>'.
                '<td>'.$pollQuestion->question.'</td>'.
                '<td>'.$multipleAnswer.'</td>'.
                '<td>'.count($answers).'</td>'.
                '<td>';?>
                    {% button url="cockpit_widget_pollquestions_edit_<?php echo $poll->id ?>_<?php echo $pollQuestion->id ?>" type="info" size="sm" icon="pencil" hint="Modifier" %}
                    {% button url="cockpit_widget_pollquestions_delete_<?php echo $poll->id ?>_<?php echo $pollQuestion->id ?>" type="danger" size="sm" icon="trash-o" confirmation="Vous confirmer vouloir supprimer cette question ?" hint="Supprimer" %}
<?php
    echo
            '</td>'.
        '</tr>';
    }
}
?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

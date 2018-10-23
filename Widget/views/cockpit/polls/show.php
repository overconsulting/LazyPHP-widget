<?php
if($pollFinished) {
    $status = '<span class="badge badge-success">Terminé</span>';
} else {
    $status = '<span class="badge badge-warning">En cours</span>';
}
?>
<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-poll">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_widget_polls" type="secondary" icon="arrow-left" size="sm" hint="Retour" %}
            {% button url="cockpit_widget_polls_edit_<?php echo $poll->id; ?>" type="info" size="sm" icon="pencil" hint="Modifier" %}
            {% button url="cockpit_widget_polls_delete_<?php echo $poll->id; ?>" type="danger" size="sm" icon="trash-o" confirmation="Vous confirmer vouloir supprimer ce sondage ?" hint="Supprimer" %}
        </div>
    </div>
    <div class="box-body">
        <h3><?php echo $poll->label; ?></h3>
        <p>Du <?php echo $poll->formatDatetime($poll->date_start, '%d/%m/%Y %H:%M:%S'); ?> au <?php echo $poll->formatDatetime($poll->date_end, '%d/%m/%Y %H:%M:%S'); ?></p>
        <p>Etat : <?php echo $status; ?></p>
        <p>Participants : <?php echo $participants['participantCount'].' / '.$participants['userCount']; ?></p>
        <hr />
        {% widget type="poll" id="<?php echo $poll->id; ?>" cockpit="1" %}
    </div>
</div>

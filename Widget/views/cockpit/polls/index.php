<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-poll">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_widget_polls_new" type="success" icon="plus" size="sm" hint="Ajouter" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th>Titre</th>
                    <th width="20%">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($polls as $poll) {
    echo
        '<tr>'.
            '<td>'.$poll->id.'</td>'.
            '<td>'.$poll->label.'</td>'.
            '<td>';?>
                {% button url="cockpit_widget_polls_show_<?php echo $poll->id ?>" type="primary" size="sm" icon="eye" hint="Voir" %}
                {% button url="cockpit_widget_polls_edit_<?php echo $poll->id ?>" type="info" size="sm" icon="pencil" hint="Modifier" %}
                {% button url="cockpit_widget_polls_delete_<?php echo $poll->id ?>" type="danger" size="sm" icon="trash-o" confirmation="Vous confirmer vouloir supprimer ce sondage?" hint="Supprimer" %}
<?php
echo
        '</td>'.
    '</tr>';
}
?>
            </tbody>
        </table>
    </div>
</div>
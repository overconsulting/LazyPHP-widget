<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-ciel">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_widget_galleries_new" type="success" icon="plus" size="sm" hint="Ajouter" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($params['galleries'] as $gallery) {
    echo
        '<tr>'.
            '<td>'.$gallery->id.'</td>'.
            '<td>'.$gallery->title.'</td>'.
            '<td>'.$gallery->description.'</td>'.
            '<td>';?>
                {% button url="cockpit_widget_galleries_edit_<?php echo $gallery->id ?>" type="info" size="sm" icon="pencil" hint="Modifier" %}
                {% button url="cockpit_widget_galleries_delete_<?php echo $gallery->id ?>" type="danger" size="sm" icon="trash-o" confirmation="Vous confirmer vouloir supprimer cette gallerie?" hint="Supprimer" %}
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
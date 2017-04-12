<h1 class="page-title"><i class="fa fa-picture-o"></i> {{ pageTitle }}</h1>
<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Liste des galleries</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_widget_galleries_new" type="success" icon="plus" content="" class="btn-xs" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover">
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
                {% button url="cockpit_widget_galleries_edit_<?php echo $gallery->id ?>" type="primary" size="xs" icon="pencil" content="" %}
                {% button url="cockpit_widget_galleries_delete_<?php echo $gallery->id ?>" type="danger" size="xs" icon="trash-o" confirmation="Vous confirmer vouloir supprimer cette gallerie?" %}
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
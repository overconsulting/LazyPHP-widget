<h1 class="page-title">{{ pageTitle }}</h1>
<div class="actions">
    {% button url="cockpit_widget_galleries" type="default" icon="arrow-left" content="Retour" %}
</div>
<div class="box box-success">
    <div class="box-header">
        <h3>Infos gallerie</h3>
    </div>
    <div class="box-body">
        {% form_open id="formGallery" action="formAction" class="form-horizontal" %}
            {% input_text name="title" model="gallery.title" label="Titre" %}
            {% input_textarea name="description" model="gallery.description" label="Description" %}
            {% input_hidden id="added_medias" name="added_medias" value="" %}
            {% input_submit name="submit" value="save" formId="formGallery" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>

<div class="box box-success">
    <div class="box-header">
        <h3>Medias de la gallerie</h3>
        <div class="box-tools pull-right">
            {% button type="success" icon="picture-o" content="Ajouter des medias..." size="lg" class="input-media-button" data-input-id="added_medias" data-select-multiple="1" data-media-type="image" data-on-valid="mediaAdded" %}
        </div>
    </div>
    <div class="box-body">
        <table id="gallery_medias" class="table table-hover">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th>Media</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Position</th>
                    <th>Active</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($params['gallery']->galleriesmedias as $galleryMedia) {
    if ($galleryMedia->active == 1) {
        $active = '<i class="fa fa-check"></i>';
    } else {
        $active = '<i class="fa fa-times"></i>';
    }

    $position = '{% button id="gallerymedia_"'.$galleryMedia->id.'_down" class="btn-position-down" size="xs" icon="caret-up" %}{% button id="gallerymedia_"'.$galleryMedia->id.'_up" class="btn-postion-up" size="xs" icon="caret-down" %}';

    echo
        '<tr>'.
            '<td>'.$galleryMedia->id.'</td>'.
            '<td>'.$galleryMedia->media->getHtml().'</td>'.
            '<td>'.$galleryMedia->title.'</td>'.
            '<td>'.$galleryMedia->description.'</td>'.
            '<td>'.$position.'</td>'.
            '<td>'.$active.'</td>'.
            '<td>';?>
                {% button url="cockpit_widget_galleriesmedias_edit_$gallery.id$_<?php echo $galleryMedia->id ?>" type="primary" size="xs" icon="pencil" content="" %}
                {% button url="cockpit_widget_galleriesmedias_delete_$gallery.id$_<?php echo $galleryMedia->id ?>" type="danger" size="xs" icon="trash-o" confirmation="Vous confirmer vouloir supprimer ce media?" %}
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

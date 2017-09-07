<h1 class="page-title">{{ pageTitle }}</h1>

<div class="box box-ciel">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_widget_galleries" type="secondary" size="sm" icon="arrow-left" content="" %}
        </div>
    </div>
    <div class="box-body">
        {% form_open id="formGallery" action="formAction" %}
            {% input_text name="title" model="gallery.title" label="Titre" %}
            {% input_textarea name="description" model="gallery.description" label="Description" %}
            {% input_hidden id="added_medias" name="added_medias" value="" %}
            {% input_submit name="submit" value="save" formId="formGallery" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>

<?php if (isset($gallery->id)): ?>
<div class="box box-ciel">
    <div class="box-header">
        <h3 class="box-title">Medias de la gallerie</h3>
        <div class="box-tools pull-right">
            {% button type="success" icon="picture-o" content="" size="sm" class="input-media-button" data-input-id="added_medias" data-select-multiple="1" data-media-type="image" data-on-valid="galleryMediasAdded" data-multiple="1" %}
        </div>
    </div>
    <div class="box-body">
        <table id="gallery_medias" class="table table-hover">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th width="2%">Media</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Lien</th>
                    <!-- <th width="2%">Position</th> -->
                    <th width="2%">Active</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
$galleriesmedias = $params['gallery']->galleriesmedias;
if ($galleriesmedias !== null && count($galleriesmedias) > 0) {
    foreach ($params['gallery']->galleriesmedias as $galleryMedia) {
        if ($galleryMedia->active == 1) {
            $active = '<i class="fa fa-check"></i>';
        } else {
            $active = '<i class="fa fa-times"></i>';
        }

        $position = '{% button id="gallerymedia_"'.$galleryMedia->id.'_down" class="btn-position-down" size="sm" icon="caret-up" %}{% button id="gallerymedia_"'.$galleryMedia->id.'_up" class="btn-position-up" size="sm" icon="caret-down" %}';

        echo
            '<tr>'.
                '<td>'.$galleryMedia->id.'</td>'.
                '<td>'.$galleryMedia->media->getHtml().'</td>'.
                '<td>'.$galleryMedia->title.'</td>'.
                '<td>'.$galleryMedia->description.'</td>'.
                '<td>'.$galleryMedia->url.'</td>'.
                // '<td>'.$position.'</td>'.
                '<td>'.$active.'</td>'.
                '<td>';?>
                    {% button url="cockpit_widget_galleriesmedias_edit_$gallery.id$_<?php echo $galleryMedia->id ?>" type="info" size="sm" icon="pencil" content="" %}
                    {% button url="cockpit_widget_galleriesmedias_delete_$gallery.id$_<?php echo $galleryMedia->id ?>" type="danger" size="sm" icon="trash-o" confirmation="Vous confirmer vouloir supprimer ce media?" %}
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

<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-ciel">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
    		{% button url="cockpit_widget_galleries_edit_$galleryId$" type="secondary" icon="arrow-left" size="sm" hint="Retour" %}
		</div>
	</div>

	<div class="box-body">
		{% form_open id="formGalleryMedia" action="formAction" %}
			{% input_media name="media_id" model="galleryMedia.media_id" label="media" mediaType="image" %}
			{% input_text name="title" model="galleryMedia.title" label="Titre" %}
			{% input_textarea name="description" model="galleryMedia.description" label="Description" %}
			{% input_text name="url" model="galleryMedia.url" label="Lien" %}
			{% input_checkbox name="active" model="galleryMedia.active" label="Actif" %}
			{% input_submit name="submit" value="save" formId="formGalleryMedia" class="btn-primary" icon="save" label="Enregistrer" %}
		{% form_close %}
	</div>
</div>

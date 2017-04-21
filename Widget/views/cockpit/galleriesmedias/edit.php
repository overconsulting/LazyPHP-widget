<h1 class="page-title">{{ pageTitle }}</h1>
<div class="actions">
    {% button url="cockpit_widget_galleries_edit_$galleryId$" type="default" icon="arrow-left" content="Retour" %}
</div>
{% form_open id="formGalleryMedia" action="formAction" class="form-horizontal" %}
	{% input_media name="media_id" model="galleryMedia.media_id" label="media" mediaType="image" %}
	{% input_text name="title" model="galleryMedia.title" label="Titre" %}
	{% input_textarea name="description" model="galleryMedia.description" label="Description" %}
	{% input_checkbox name="active" model="galleryMedia.active" label="Actif" %}
	{% input_submit name="submit" value="save" formId="formGalleryMedia" class="btn-primary" icon="save" label="Enregistrer" %}
{% form_close %}

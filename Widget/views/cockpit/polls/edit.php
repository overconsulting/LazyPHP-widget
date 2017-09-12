<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-brown">
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
            {% input_text name="date_start" model="poll.date_start" label="Date de début" %}
            {% input_text name="date_end" model="poll.date_end" label="Date de fin" %}
            {% input_submit name="submit" value="save" formId="formPoll" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>

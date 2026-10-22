{**
 * plugins/generic/customHeadInjector/templates/settingsForm.tpl
 *
 * Copyright (c) 2026 Oscar R. Gómez <info@menteclara.org>
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * Custom Head Injector plugin settings form for MOJP 4.0 compatible with OJS 3.5.0.5 or higher.
 *
 *}
<script>
	$(function() {ldelim}
		// Attach the form handler.
		$('#customHeadSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="customHeadSettingsForm" method="post" action="{url router=PKP\core\PKPApplication::ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}">
	{csrf}
	{include file="controllers/notification/inPlaceNotification.tpl" notificationId="customHeadSettingsFormNotification"}

	<div id="description">
		<p>{translate key="plugins.generic.customHeadInjector.manager.settings.description"}</p>
	</div>

	{fbvFormArea id="customHeadSettingsFormArea"}
		{fbvElement type="textarea" id="customHeadCode" value=$customHeadCode label="plugins.generic.customHeadInjector.manager.settings.customHeadCode" placeholder="<!-- Pega aquí tus etiquetas meta, link, styles, scripts o Schema.org -->" rows="15"}
	{/fbvFormArea}

	{fbvFormButtons}
</form>
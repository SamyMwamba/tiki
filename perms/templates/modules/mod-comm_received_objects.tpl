{* $Id$ *}

{if $prefs.feature_comm eq 'y'}
	{if !isset($tpl_module_title)}{assign var=tpl_module_title value="{tr}Received objects{/tr}"}{/if}
	
	{tikimodule error=$module_params.error title=$tpl_module_title name="comm_received_objects" flip=$module_params.flip decorations=$module_params.decorations nobox=$module_params.nobox notitle=$module_params.notitle}
		<div>
			<span class="module">{tr}Pages:{/tr}</span>
			<span class="module">&nbsp;{$modReceivedPages}</span>
		</div>
	{/tikimodule}
{/if}

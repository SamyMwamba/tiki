{extends "layout_view.tpl"}

{block name="content"}
	<table class="table">
		<tr>
			<th>{tr}Count{/tr}</th>
			<th>{tr}Label{/tr}</th>
		</tr>
		{foreach $conditions as $key => $condition}
			<tr>
				<td>
					{if $condition.operator eq 'atLeast'}
						&ge;
					{else}
						&le;
					{/if}
					{$condition.count|escape}
				</td>
				<td>
					<a class="edit-condition" href="#" data-condition="{$key|escape}">{$condition.label|escape}</a>
					<a class="delete-condition pull-right text-danger" href="#" data-condition="{$key|escape}">{glyph name=remove} {tr}Delete{/tr}</a>
				</td>
			</tr>
		{foreachelse}
			<tr>
				<td colspan="2">{tr}No conditions yet!{/tr}</td>
			</tr>
		{/foreach}
	</table>
	<button class="btn btn-default add-condition pull-right">{glyph name=plus} {tr}Add Condition{/tr}</button>
	<input type="hidden" name="conditions" value="{$conditions|json_encode|escape}">
{/block}

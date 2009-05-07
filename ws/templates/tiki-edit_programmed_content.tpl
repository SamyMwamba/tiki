{title url="tiki-edit_programmed_content.php?contentId=$contentId"}{tr}Program dynamic content for block:{/tr} {$contentId}{/title}

<div class="navbar">
	{button href="?contentId=$contentId" _text="{tr}Create New Block{/tr}"}
	{button href="tiki-list_contents.php" _text="{tr}Return to block listing{/tr}"}
</div>

<h2>{tr}Block description: {/tr}{$description}</h2>

<h2>
	{if $data}
		{tr}Edit{/tr}
	{else}
		{tr}Create{/tr}
	{/if} 
	{tr}content{/tr}
</h2>

{if $pId}
	{tr}You are editing block:{/tr} {$pId}<br />
{/if}

<form action="tiki-edit_programmed_content.php" method="post">
	<input type="hidden" name="contentId" value="{$contentId|escape}" />
	<input type="hidden" name="pId" value="{$pId|escape}" />
	<table class="normal">
		<tr>
			<td class="formcolor">Description:</td>
			<td class="formcolor">
				<textarea rows="5" cols="40" name="data">{$data|escape}</textarea>
			</td>
		</tr>
		<tr>
			<td class="formcolor">{tr}Publishing date{/tr}</td>
			<td class="formcolor">
				{html_select_date time=$publishDate end_year="+1" field_order=$prefs.display_field_order} {tr}at{/tr} {html_select_time time=$publishDate display_seconds=false}</td>
		</tr>
		<tr>
			<td class="formcolor">&nbsp;</td>
			<td class="formcolor">
				<input type="submit" name="save" value="{tr}Save{/tr}" />
			</td>
		</tr>
	</table>
</form>

<h2>{tr}Versions{/tr}</h2>

{if $listpages or ($find ne '')}
	{include file='find.tpl'}
{/if}

<table class="normal">
  <tr>
    <th>{self_link _sort_arg='sort_mode' _sort_field='pId'}{tr}Id{/tr}{/self_link}</th>
    <th>{self_link _sort_arg='sort_mode' _sort_field='publishDate'}{tr}Publishing Date{/tr}{/self_link}</th>
    <th>{self_link _sort_arg='sort_mode' _sort_field='data'}{tr}Data{/tr}{/self_link}</th>
    <th>{tr}Action{/tr}</th>
  </tr>
	{section name=changes loop=$listpages}
		<tr>
			{if $actual eq $listpages[changes].publishDate}
				{assign var=class value=third}
			{else}
				{if $actual > $listpages[changes].publishDate}
					{assign var=class value=odd}
				{else}
					{assign var=class value=even}
				{/if}
			{/if}
			<td class="{$class}">&nbsp;{$listpages[changes].pId}&nbsp;</td>
			<td class="{$class}">&nbsp;{$listpages[changes].publishDate|tiki_short_datetime}&nbsp;</td>
			<td class="{$class}">&nbsp;{$listpages[changes].data|escape:'html'|nl2br}&nbsp;</td>
			<td class="{$class}">
				<a class="link" href="tiki-edit_programmed_content.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;contentId={$contentId}&amp;edit={$listpages[changes].pId}" title="{tr}Edit{/tr}">{icon _id=page_edit}</a>
				<a class="link" href="tiki-edit_programmed_content.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;contentId={$contentId}&amp;remove={$listpages[changes].pId}" title="{tr}Remove{/tr}">{icon _id=cross alt="{tr}Remove{/tr}"}</a>
			</td>
		</tr>
	{sectionelse}
		<tr>
			<td colspan="4" class="odd">
				<b>{tr}No records found{/tr}</b>
			</td>
		</tr>
	{/section}
</table>

{pagination_links cant=$cant step=$prefs.maxRecords offset=$offset}{/pagination_links}

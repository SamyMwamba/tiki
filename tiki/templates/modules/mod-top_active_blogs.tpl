{* $Header: /cvsroot/tikiwiki/tiki/templates/modules/mod-top_active_blogs.tpl,v 1.14 2007-10-14 17:51:02 mose Exp $ *}

{if $prefs.feature_blogs eq 'y'}
{if !isset($tpl_module_title)}
{if $nonums eq 'y'}
{eval var="`$module_rows` {tr}Most Active blogs{/tr}" assign="tpl_module_title"}
{else}
{eval var="{tr}Most Active blogs{/tr}" assign="tpl_module_title"}
{/if}
{/if}
{tikimodule title=$tpl_module_title name="top_active_blogs" flip=$module_params.flip decorations=$module_params.decorations nobox=$module_params.nobox}
<table  border="0" cellpadding="0" cellspacing="0">
{section name=ix loop=$modTopActiveBlogs}
<tr>{if $nonums != 'y'}<td class="module" valign="top">{$smarty.section.ix.index_next})</td>{/if}
<td class="module"><a class="linkmodule" href="tiki-view_blog.php?blogId={$modTopActiveBlogs[ix].blogId}">{$modTopActiveBlogs[ix].title}</a></td></tr>
{/section}
</table>
{/tikimodule}
{/if}

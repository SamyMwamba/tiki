{* $Header: /cvsroot/tikiwiki/tiki/templates/modules/mod-directory_last_sites.tpl,v 1.12 2007-05-31 09:42:59 nyloth Exp $ *}

{if $feature_directory eq 'y'}
{if !isset($tpl_module_title)}
{if $nonums eq 'y'}
{eval var="{tr}Last `$module_rows` Sites{/tr}" assign="tpl_module_title"}
{else}
{eval var="{tr}Last Sites{/tr}" assign="tpl_module_title"}
{/if}
{/if}
{tikimodule title=$tpl_module_title name="directory_last_sites" flip=$module_params.flip decorations=$module_params.decorations}
  <table  border="0" cellpadding="1" cellspacing="0" width="100%">
  {section name=ix loop=$modLastdirSites}
    <tr>
      {if $nonums != 'y'}<td valign="top" class="module">{$smarty.section.ix.index_next})</td>{/if}
      <td class="module">
	  	{if $absurl == 'y'}
          <a class="linkmodule" href="{$base_url}tiki-directory_redirect.php?siteId={$modLastdirSites[ix].siteId}" {if $directory_open_links eq 'n'}target="_new"{/if}>
          {$modLastdirSites[ix].name}
          </a>
		  {else}
        <a class="linkmodule" href="tiki-directory_redirect.php?siteId={$modLastdirSites[ix].siteId}" {if $directory_open_links eq 'n'}target="_new"{/if}>
          {$modLastdirSites[ix].name}
        </a>
		{/if}
      </td>
    </tr>
  {/section}
  </table>
{/tikimodule}
{/if}

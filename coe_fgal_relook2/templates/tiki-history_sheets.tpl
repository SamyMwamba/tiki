
{title help="Spreadsheet"}{tr}Spreadsheet History:{/tr} {$title}{/title}

<div>
  {$description|escape}
</div>
<form>
	{tabset}
		{if not $grid_content eq ''}
			{tab name="{tr}View{/tr}"}
				<table style="width: 100%;" id="tiki_sheet_container">
					<tr>
						<td>
							{pagination_links cant=$ver_cant itemname="{tr}Sheet{/tr}" offset_arg="idx_0" offset=$sheetIndexes[0] show_numbers=n}{/pagination_links}
						</td>
						<td>
							{pagination_links cant=$ver_cant itemname="{tr}Sheet{/tr}" offset_arg="idx_1" offset=$sheetIndexes[1] show_numbers=n}{/pagination_links}
						</td>
					</tr>
					<tr>
						{section name=date loop=$grid_content}
							<td style="width: 50%;">
								<div style="font-size: 1.5em; text-align: center;">
									Revision: {$history[$smarty.section.date.index].prettystamp}
								</div>
								
								<div class="tiki_sheet" {if !empty($tiki_sheet_div_style)} style="{$tiki_sheet_div_style}"{/if}>
									{$grid_content[$smarty.section.date.index]}
								</div>
								
								<div style="text-align: center;">
									{button href="tiki-view_sheets.php?sheetId=$sheetId&readdate=`$history[$smarty.section.date.index].stamp`&parse=y" class="view_button" _text="{tr}View{/tr}" _htmlelement="role_main" _title="{tr}View{/tr}"}
									{button href="tiki-view_sheets.php?sheetId=$sheetId&readdate=`$history[$smarty.section.date.index].stamp`&parse=clone" class="clone_button" _text="{tr}Clone{/tr}" _htmlelement="role_main" _title="{tr}Clone{/tr}"}
									{button href="tiki-view_sheets.php?sheetId=$sheetId&readdate=`$history[$smarty.section.date.index].stamp`&parse=rollback" class="rollback_button" _text="{tr}Rollback{/tr}" _htmlelement="role_main" _title="{tr}Rollback{/tr}"}
								</div>
							</td>
						{/section}
					</tr>
				</table>
				
				<div class="navbar" style="text-align: center;">
					{button _id="go_fullscreen" _text="{tr}Toggle Full Screen{/tr}"}
				</div>
			{/tab}
		{/if}
	
		{tab name="{tr}Date Selection{/tr}"}
			<table style="width: 100%;">
				<tr>
					<th>{tr}Edit Date{/tr}</th>
					<th>{tr}User{/tr}</th>
					<th>{tr}Actions{/tr}</th>
					<th colspan="2">
						<input type="hidden" name="sheetId" id="sheetId" value="{$sheetId}" />
						<input type="submit" id="compareSheetsSubmit" value="compare" return false;" />
					</th>
				</tr>
				{section name=revision_date loop=$history}
					<tr>
						<td>
							{$history[revision_date].prettystamp}
						</td>
			    		<td>
			    			{$history[revision_date].user}
			    		</td>
			    		<td style="text-align: center;">
			    			<a href="tiki-view_sheets.php?sheetId={$sheetId}&readdate={$history[revision_date].stamp}&parse=y" title="{tr}View Spreadsheet{/tr}">{tr}View{/tr}</a> |
			    			<a href="tiki-view_sheets.php?sheetId={$sheetId}&readdate={$history[revision_date].stamp}&parse=clone" title="{tr}Clone Spreadsheet{/tr}">{tr}Clone{/tr}</a> |
			    			<a href="tiki-view_sheets.php?sheetId={$sheetId}&readdate={$history[revision_date].stamp}&parse=rollback" title="{tr}Roll Back Spreadsheet{/tr}">{tr}Roll-Back{/tr}</a>
			    		</td>
			    		<td style="vertical-align: middle; text-align: center;">
						   	<input type="radio" name="idx_0" class="compareSheet1" value="{$smarty.section.revision_date.index}" onclick="$.sheet.compareSheetClick($('input.compareSheet1'), $('input.compareSheet2'));" />
				    	</td>
			    		<td style="vertical-align: middle; text-align: center;">
						   	<input type="radio" name="idx_1" class="compareSheet2" value="{$smarty.section.revision_date.index}" onclick="$.sheet.compareSheetClick($('input.compareSheet1'), $('input.compareSheet2'));" />
				    	</td>
			    	</tr>
				{/section}
			</table>
		{/tab}
	{/tabset}
</form>
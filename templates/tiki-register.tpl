{* $Id$ *}
{* test for caps lock*}
{literal}
	<script type="text/javascript">
	<!--
		function regCapsLock(e){
			kc = e.keyCode?e.keyCode:e.which;
			sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
			if(((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk))
				document.getElementById('divRegCapson').style.visibility = 'visible';
			else
				document.getElementById('divRegCapson').style.visibility = 'hidden';
		}
	// -->
	</script>
{/literal}

{title admpage='login'}{tr}Registration{/tr}{/title}
	
	<div class="simplebox highlight" id="divRegCapson" style="visibility:hidden">{icon _id=error style="vertical-align:middle"} {tr}CapsLock is on.{/tr}</div>

{if $prefs.feature_ajax eq 'y'}
		<script src="lib/registration/register_ajax.js" type="text/javascript"></script>
{/if}

{if $showmsg eq 'y'}
		<div class="simplebox highlight">
	{$msg|nl2br}
		</div>

{elseif $userTrackerData}
	{$userTrackerData}

{elseif $email_valid eq 'n'}
	<label for="email">{icon _id=error style="vertical-align:middle" align="left"} {tr}Your email could not be validated; make sure you email is correct and click register below.{/tr}</label>
 		<form action="tiki-register.php" method="post">
			<input type="text" name="email" id="email" value="{$smarty.post.email}"/>
			<input type="hidden" name="name" value="{$smarty.post.name}"/>
			<input type="hidden" name="pass" value="{$smarty.post.pass}"/>
			<input type="hidden" name="regcode" value="{$smarty.post.regcode}"/>
			<input type="hidden" name="novalidation" value="yes"/>
	{if isset($smarty.post.antibotcode)}		<input type="hidden" name="antibotcode" value="{$smarty.post.antibotcode}"/>{/if}
	{if $smarty.post.chosenGroup}		<input type="hidden" name="chosenGroup" value="{$smarty.post.chosenGroup}" />{/if}
			<input type="submit" name="register" value="{tr}Register{/tr}" />
		</form>

{else}

		<form action="tiki-register.php" method="post" name="RegForm">
		<fieldset><legend>{tr}Register as a new user{/tr}</legend>
			<table class="form">

				<tr>
					<td class="formcolor"><label for="name">{if $prefs.login_is_email eq 'y'}{tr}Email{/tr}{else}{tr}Username{/tr}{/if}:</label></td>
					<td class="formcolor">
						<input type="text" name="name" id="name" {if $prefs.feature_ajax eq 'y'} onkeyup="return check_name()" onblur="return check_name()"{/if} />
						{if $prefs.feature_ajax eq 'y'}<span id="ajax_msg_name" style="vertical-align: middle;"></span>{/if}
						{if $prefs.login_is_email eq 'y'}
						<em>{tr}Use your email as login{/tr}</em>.
						{else}
							{if $prefs.min_username_length > 1}<div class="highlight"><em>{tr}Minimum {$prefs.min_username_length} characters long{/tr}</em></div>{/if}
							{if $prefs.lowercase_username eq 'y'}<div class="highlight"><em>{tr}Lowercase only{/tr}</em></div>{/if}
						{/if}
					</td>
				</tr>

	{if $prefs.useRegisterPasscode eq 'y'}
				<tr>
					<td class="formcolor"><label for="passcode">{tr}Passcode to register:{/tr}</label></td>
					<td class="formcolor">
						<input type="password" name="passcode" id="passcode" onkeypress="regCapsLock(event)" />
						<em>{tr}Not your password.{/tr} {tr}To request a passcode, {if $prefs.feature_contact eq 'y'}<a href="tiki-contact.php">{/if}
						contact the sytem administrator{if $prefs.feature_contact eq 'y'}</a>{/if}{/tr}.</em>
					</td>
				</tr>
	{/if}
 
				<tr>
					<td class="formcolor"><label for="pass1">{tr}Password:{/tr}</label></td>
					<td class="formcolor">
						<input id='pass1' type="password" name="pass" onkeypress="regCapsLock(event)" onkeyup="runPassword(this.value, 'mypassword');{if $prefs.feature_ajax eq 'y'}check_pass();{/if}" />
						<span id="mypassword_text"></span>
						<span id="mypassword_bar" style="font-size: 5px; height: 2px; width: 0px;"></span>
						{if $prefs.feature_ajax ne 'y'}
							{if $prefs.min_pass_length > 1}<div class="highlight"><em>{tr}Minimum {$prefs.min_pass_length} characters long{/tr}</em></div>{/if}
							{if $prefs.pass_chr_num eq 'y'}<div class="highlight"><em>{tr}Password must contain both letters and numbers{/tr}</em></div>{/if}
						{/if}
					</td>
				</tr>

				<tr>
					<td class="formcolor" style="vertical-align:top"><label for="pass2">{tr}Repeat password:{/tr}</label></td>
					<td class="formcolor">
						<input id='pass2' type="password" name="passAgain" onkeypress="regCapsLock(event)" {if $prefs.feature_ajax eq'y'}onkeyup="check_pass()"{/if}/>
						{if $prefs.feature_ajax eq'y'}<span id="checkpass"></span>{/if}
						{if $prefs.generate_password eq 'y'}
							<p>
							{if $prefs.feature_ajax eq 'y'}
								{button href="#" _onclick="genPass('genepass','pass1','pass2');runPassword(document.RegForm.genpass.value, 'mypassword');check_pass();"	_text="{tr}Generate a password:{/tr}"}
							{else}
								{button href="#" _onclick="genPass('genepass','pass1','pass2');runPassword(document.RegForm.genpass.value, 'mypassword');"	_text="{tr}Generate a	password:{/tr}"}
							{/if}
							<input id='genepass' name="genpass" type="text" />
							</p>
						{/if}
					</td>
				</tr>

	{if $prefs.login_is_email ne 'y'}
				<tr>
					<td class="formcolor"><label for="email">{tr}Email:{/tr}</label></td>
					<td class="formcolor"><input type="text" id="email" name="email" {if $prefs.feature_ajax eq 'y'}onkeyup="return check_mail()" onblur="return check_mail()"{/if}/>
						{if $prefs.feature_ajax eq 'y'}<span id="ajax_msg_mail" style="vertical-align: middle;"></span>{/if}
						{if $prefs.validateUsers eq 'y' and $prefs.validateEmail ne 'y'}
						<div class="highlight"><em class='mandatory_note'>{tr}A valid email is mandatory to register{/tr}</em></div>
						{/if}
					</td>
				</tr>
	{/if}
	{* Custom fields *}
	{section name=ir loop=$customfields}
		{if $customfields[ir].show}
				<tr>
					<td class="form"><label for="{$customfields[ir].prefName}">{tr}{$customfields[ir].label}:{/tr}</label></td>
					<td class="form"><input type="{$customfields[ir].type}" name="{$customfields[ir].prefName}" value="{$customfields[ir].value}" size="{$customfields[ir].size}" id="{$customfields[ir].prefName}" /></td>
				</tr>
		{/if}
	{/section}
      
    {* Groups *}
	{if isset($theChoiceGroup)}
				<input type="hidden" name="chosenGroup" value="{$theChoiceGroup|escape}" />
	{elseif $listgroups}
				<tr>
					<td class="formcolor">{tr}Group{/tr}</td>
					<td class="formcolor">
		{foreach item=gr from=$listgroups}
			{if $gr.registrationChoice eq 'y'}
				<div class="registergroup">
					 <input type="radio" name="chosenGroup" id="gr_{$gr.groupName}" value="{$gr.groupName|escape}" /> 
					 <label for="gr_{$gr.groupName}">
					 	{if $gr.groupDesc}
					 		{tr}{$gr.groupDesc|escape}{/tr}
						{else}
							{$gr.groupName|escape}
						{/if}
					</label>
				</div>
			{/if}
		{/foreach}
					</td>
				</tr>
	{/if}

	{if $prefs.rnd_num_reg eq 'y'}{include file='antibot.tpl' td_style='formcolor'}{/if}

				<tr>
					<td class="formcolor">&nbsp;</td>
					<td class="formcolor"><input type="submit" name="register" value="{tr}Register{/tr}" /></td>
				</tr>
			</table>
			</fieldset>
		</form>
		{remarksbox type="note"  title="{tr}Note{/tr}"}
			{tr}Make sure to whitelist this domain to prevent registration emails being canned by your spam filter!{/tr}
		{/remarksbox}
{/if}

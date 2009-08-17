<?php

// $Id: /cvsroot/tikiwiki/tiki/tiki-list_surveys.php,v 1.19 2007-10-12 07:55:28 nyloth Exp $

// Copyright (c) 2002-2007, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
$section = 'surveys';
require_once ('tiki-setup.php');

include_once ('lib/surveys/surveylib.php');

if ($prefs['feature_surveys'] != 'y') {
	$smarty->assign('msg', tra("This feature is disabled").": feature_surveys");

	$smarty->display("error.tpl");
	die;
}

if($tiki_p_take_survey!= 'y') {
	$smarty->assign('errortype', 401);
	$smarty->assign('msg',tra("You don't have permission to use this feature"));
	$smarty->display("error.tpl");
	die;
}

if (!isset($_REQUEST["sort_mode"])) {
	$sort_mode = 'created_desc';
} else {
	$sort_mode = $_REQUEST["sort_mode"];
}

if (!isset($_REQUEST["offset"])) {
	$offset = 0;
} else {
	$offset = $_REQUEST["offset"];
}

$smarty->assign_by_ref('offset', $offset);

if (isset($_REQUEST["find"])) {
	$find = $_REQUEST["find"];
} else {
	$find = '';
}

$smarty->assign('find', $find);

$smarty->assign_by_ref('sort_mode', $sort_mode);
$channels = $srvlib->list_surveys($offset, $maxRecords, $sort_mode, $find);
Perms::bulk( array( 'type' => 'survey' ), 'object', $channels['data'], 'surveyId' );
$temp_max = count($channels["data"]);
for ($i = 0; $i < $temp_max; $i++) {
	$survperms = Perms::get( array( 'type' => 'survey', 'object' => $channels['data'][$i]['surveyId'] ) );
	$channels["data"][$i]["individual_tiki_p_take_survey"] = $survperms->take_survey ? 'y' : 'n';
	$channels["data"][$i]["individual_tiki_p_view_survey_stats"] = $survperms->view_survey_stats ? 'y' : 'n';
	$channels["data"][$i]["individual_tiki_p_admin_surveys"] = $survperms->admin_surveys ? 'y' : 'n';


	if ($tikilib->user_has_voted($user, 'survey' . $channels["data"][$i]["surveyId"])) {
		$channels["data"][$i]["taken_survey"] = 'y';
	} else {
		$channels["data"][$i]["taken_survey"] = 'n';
	}
}

$smarty->assign_by_ref('cant_pages', $channels["cant"]);

$smarty->assign_by_ref('channels', $channels["data"]);

include_once ('tiki-section_options.php');
ask_ticket('list-surveys');

// Display the template
$smarty->assign('mid', 'tiki-list_surveys.tpl');
$smarty->display("tiki.tpl");

<?php

// $Header: /cvsroot/tikiwiki/tiki/tiki-map_rss.php,v 1.5 2004-01-15 09:56:26 redflo Exp $

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

require_once ('tiki-setup.php');
require_once ('lib/tikilib.php');

if ($rss_mapfiles != 'y') {
        $errmsg=tra("rss feed disabled");
        require_once ('tiki-rss_error.php');
}

if($tiki_p_map_view != 'y') {
        $errmsg=tra("Permission denied you cannot view this section");
        require_once ('tiki-rss_error.php');
}

$feed = "map";
$title = "Tiki RSS feed for maps"; // TODO: make configurable
$desc = "List of maps available."; // TODO: make configurable
$now = date("U");
$id = "name";
$titleId = "name";
$descId = "description";
$dateId = "lastModif";
$readrepl = "tiki-map.phtml?mapfile=";

require ("tiki-rss_readcache.php");

if ($output == "EMPTY") {
  // Get mapfiles from the mapfiles directory
  $tmp = array();
  $h = opendir($map_path);

  while (($file = readdir($h)) !== false)
  {
  	if (preg_match('/\.map$/i', $file))
  	{
  		$filetlist[$file] = filemtime ($map_path."/".$file);
  	}
  }
  arsort($filetlist, SORT_NUMERIC);

  $aux = array();
  $i=0;
  while (list ($key, $val) = each ($filetlist))
  {
    if ($i >= $max_rss_mapfiles) break;
    $i++;
  	$aux["name"] = $key;
  	$aux["lastModif"] = $val;
  	$aux["description"] = "";
  	$tmp[] = $aux;
  }

  closedir ($h);
  $changes = array();
  $changes["data"] = $tmp;
  $output = "";
}

require ("tiki-rss.php");

?>

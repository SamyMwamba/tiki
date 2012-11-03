<?php
// (c) Copyright 2002-2012 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

include_once "lib/jquery/elfinder/php/elFinderConnector.class.php";
include_once "lib/jquery/elfinder/php/elFinder.class.php";
include_once "lib/jquery/elfinder/php/elFinderVolumeDriver.class.php";

include_once 'lib/jquery_tiki/elfinder/elFinderVolumeTikiFiles.class.php';

class Services_File_FinderController
{
	private $fileController;

	function setUp()
	{
		global $prefs;

		if ($prefs['feature_file_galleries'] != 'y') {
			throw new Services_Exception_Disabled('feature_file_galleries');
		}
		if ($prefs['fgal_elfinder_feature'] != 'y') {
			throw new Services_Exception_Disabled('fgal_elfinder_feature');
		}
		$this->fileController = new Services_File_Controller();
	}

	/**********************
	 * elFinder functions *
	 *********************/

	/***
	 * Main "connector" to handle all requests from elfinder
	 *
	 * @param $input
	 * @return array
	 * @throws Services_Exception_Disabled
	 */

	public function action_finder($input)
	{
		static $galleriesParentIds = null;

		if ($galleriesParentIds === null) {
			$ids = TikiLib::lib('filegal')->getGalleriesParentIds();
			$galleriesParentIds = array();
			foreach ($ids as $id) {
				if ($id['parentId'] > 0) {
					$galleriesParentIds[(int) $id['galleryId']] = (int) $id['parentId'];
				}
			}

		}

		// turn off most elfinder commands here too (stops the back-end methods being accessible)
		$disabled = array('rm', 'duplicate', 'rename', 'mkdir', 'mkfile', 'upload', 'copy', 'cut', 'paste', 'edit', 'extract', 'archive', 'resize');

		$opts = array(
			'debug' => true,
			'roots' => array(
				array(
					'driver'        => 'TikiFiles',   								// driver for accessing file system (REQUIRED)
					'path'          => "{$this->fileController->defaultGalleryId}",	// path to files (REQUIRED)
					'disabled'		=> $disabled,

//					'URL'           => 									// URL to files (seems not to be REQUIRED)
					'accessControl' => array($this, 'elFinderAccess'),	// obey tiki perms
					'tmbURL'		=> 'temp/public/',
				)
			)
		);
		if ($input->defaultGalleryId->int()) {
			$opts['roots'][0]['startPath'] = "d_{$input->defaultGalleryId->int()}";	// needs to be the cached name in elfinder (with 'd_' in front)
			$opts['roots'][0]['accessControlData'] = array('startPath' => $input->defaultGalleryId->int(), 'deepGallerySearch' => $input->deepGallerySearch->int(), 'galleryParentIds' => $galleriesParentIds);
		} else if (!$input->deepGallerySearch->int()) {
			$opts['roots'][0]['startPath'] = $this->fileController->defaultGalleryId;	// root path just needs the id
			$opts['roots'][0]['accessControlData'] = array('startPath' => $this->fileController->defaultGalleryId, 'deepGallerySearch' => $input->deepGallerySearch->int(), 'galleryParentIds' => $galleriesParentIds);
		}
		//$opts['roots'][0]['treeDeep'] = $input->deepGallerySearch->int();		// 0/1

		// run elFinder
		$elFinder = new elFinder($opts);
		$connector = new elFinderConnector($elFinder);

		if ($input->cmd->text() === 'tikiFileFromHash') {	// intercept tiki only commands
			$fileId = $elFinder->realpath($input->hash->text());
			$info = TikiLib::lib('filegal')->get_file(str_replace('f_', '', $fileId));
			return $info;
		}

		// elfinder needs "raw" $_GET
		$_GET = $input->asArray();

		$connector->run();
		// deals with response

		return array();

	}

	/**
	 * elFinderAccess "accessControl" callback.
	 *
	 * @param  string  $attr  attribute name (read|write|locked|hidden)
	 * @param  string  $path  file path relative to volume root directory started with directory separator
	 * @param $data
	 * @param $volume
	 * @return bool|null
	 */
	function elFinderAccess($attr, $path, $data, $volume) {

		$ar = explode('_', $path);
		$allowed = true;		// for now
		if (count($ar) === 2) {
			$isgal = $ar[0] === 'd';
			$id = $ar[1];
			if ($isgal) {
				if (!empty($data['startPath'])) {
					if ($data['startPath'] == $id) {		// is startPath
						$allowed = true;
					} else if (isset($data['deepGallerySearch']) && $data['deepGallerySearch'] === 0) {	// not startPath and not deep
						$allowed = false;
					} else {
						$pid = $data['galleryParentIds'][$id];
						$allowed = false;
						while($pid) {
							if ($pid == $data['startPath']) {
								$allowed = true;
								break;
							}
							$pid = $data['galleryParentIds'][$pid];
						}
					}
				}
			}
		} else {
			$isgal = true;
			$id = $path;
		}

		if ($isgal) {
			$objectType = 'file gallery';
		} else {
			$objectType = 'file';
		}

		$perms = Perms::get(array( 'type' => $objectType, 'object' => $id ));

		switch($attr) {
			case 'read':
				return $allowed && $perms->download_files;
			case 'write':
				return $allowed && $perms->edit_gallery_file;
			case 'locked':
			case 'hidden':
				return !$allowed;
			default:
				return false;

		}
	}


}


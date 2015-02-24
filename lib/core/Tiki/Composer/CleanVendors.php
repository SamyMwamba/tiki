<?php
// (c) Copyright 2002-2015 by authors of the Tiki Wiki CMS Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

namespace Tiki\Composer;
use Composer\Script\Event;
use Composer\Util\FileSystem;

class CleanVendors
{
	private static $standardFiles = [
		//directories
		'development',
		'demo',
		'demos',
		'docs',
		'documentation',
		'samples',
		'examples',
		'test',
		'testing',
		'tests',
		'vendor',
		'www',
		'.gitattributes',
		'.gitignore',
		'.gitmodules',
		'.jshintrc',
		'build',
		'bower.json',
		'changelog.txt',
		'ChangeLog',
		'composer.json',
		'composer.lock',
		'Gruntfile.js',
		'Gruntfile.coffee',
		'package.json'
	];

	private static $vendorDirs = [
		'aFarkas/html5shiv',
		'alvarotrigo/fullpage.js',
		'bafs/testify',
		'ckeditor/ckeditor',
		'codemirror/codemirror',
		'cwspear/bootstrap-hover-dropdown',
		'dompdf/dompdf',
		'ezyang/htmlpurifier',
		'fivefilters/php-readability',
		'flp/flp',
		'fortawesome/font-awesome',
		'gabordemooij/redbean',
		'jcapture-applet/jcapture-applet',
		'jquery/jquery-s5',
		'jquery/jquery-sheet',
		'jquery/jquery-timepicker-addon',
		'jquery/jquery-ui-themes',
		'jquery/md5',
		'jquery/minicart',
		'jquery/plugins/anythingslider',
		'jquery/plugins/colorbox',
		'jquery/plugins/superfish',
		'jquery/plugins/form',
		'jquery/plugins/jquery-validation',
		'jquery/plugins/jquery-json',
		'jquery/plugins/treetable',
		'jquery/plugins/zoom',
		'mediumjs/mediumjs',
		'mikey179/vfsStream',
		'oyejorge/less.php',
		'phenx/php-font-lib',
		'smarty/smarty',
		'twitter/bootstrap',
		'undojs/undojs',
		'wikilingo/codemirror',
		'wikilingo/wikilingo',
		'zetacomponents/base',
		'zetacomponents/webdav',

	];

	public static function clean(Event $event)
	{
		$themes = __DIR__ . '/../../../../themes/';
		$vendors = __DIR__ . '/../../../../vendor/';

		$fs = new FileSystem;
		$fs->ensureDirectoryExists($themes);

		self::addIndexFile($themes);
		self::addIndexFile($vendors);

		self::removeStandard($vendors);
		$fs->remove($vendors . 'adodb/adodb/cute_icons_for_site');
		$fs->remove($vendors . 'aFarkas/html5shiv/build');
		$fs->remove($vendors . 'bombayworks/zendframework1/library/Zend/Service/WindowsAzure/CommandLine/Scaffolders');
		$fs->remove($vendors . 'ckeditor/samples');
		$fs->remove($vendors . 'codemirror/codemirror/mode/tiki');
		self::removeMultiple($vendors . 'cwspear/bootstrap-hover-dropdown', ['bootstrap-hover-dropdown.min.js', 'demo.html']);
		$fs->remove($vendors . 'jcapture-applet/jcapture-applet/src');
		$fs->remove($vendors . 'jquery/jquery-s5/lib/dompdf/www');
		self::removeMultiple($vendors . 'jquery/jquery-sheet', ['jquery-1.10.2.min.js', 'jquery-ui', 'parser.php']);
		self::removeMultiple($vendors . 'jquery/jquery-timepicker-addon',
			[
				'lib',
				'src',
				'jquery-ui-timepicker-addon.json',
				'jquery-ui-timepicker-addon.min.css',
				'jquery-ui-timepicker-addon.min.js'
			]
		);
		self::removeMultiple($vendors . 'jquery/jquery-ui', ['development-bundle', 'external']);
		self::removeMultiple($vendors . 'jquery/jtrack', ['js/jquery.json-2.2.min.js', 'js/jquery-1.4.2.min.js']);
		self::removeMultiple($vendors . 'jquery/md5', ['css', 'js/demo.js', 'js/md5.min.js', 'test']);
		$fs->remove($vendors . 'jquery/minicart/src');
		self::removeMultiple($vendors . 'jquery/plugins/anythingslider',
			[
				'demos.html',
				'anythingslider.jquery.json',
				'expand.html',
				'simple.html',
				'video.html'
			]
		);
		$fs->remove($vendors . 'jquery/plugins/brosho/__MACOSX');
		self::removeMultiple($vendors . 'jquery/plugins/chosen',
			[
				'docsupport',
				'chosen.css',
				'chosen.jquery.min.js',
				'chosen.min.css',
				'chosen.proto.js',
				'chosen.proto.min.js',
				'chosen-sprite.png',
				'chosen-sprite@2x.png',
				'index.proto.html',
				'options.html'
			]
		);
		$fs->remove($vendors . 'jquery/plugins/colorbox/content');
		self::removeMultiple($vendors . 'jquery/plugins/galleriffic',
			[
				'js/jquery-1.3.2.js',
				'js/jquery.history.js',
				'js/jush.js',
				'example-1.html',
				'example-2.html',
				'example-3.html',
				'example-4.html',
				'example-5.html',
			]
		);
		$fs->remove($vendors . 'jquery/plugins/infinitecarousel/jquery.infinitecarousel3.min.js');
		self::removeMultiple($vendors . 'jquery/plugins/jquery-validation',
			[
				'lib',
				'src',
				'dist/additional-methods.js',
				'dist/additional-methods.min.js',
				'dist/jquery.validate.min.js'
			]
		);
		self::removeMultiple($vendors . 'jquery/plugins/jquery-json',
			[
				'dist',
				'libs',
				'.jscsrc',
				'.jshintignore',
				'.jshintrc',
				'.travis.yml',
				'HISTORY.md',
			]
		);
		$fs->remove($vendors . 'jquery/plugins/reflection-jquery/src');
		self::removeMultiple($vendors . 'jquery/plugins/superfish',
			[
				'src',
				'superfish.jquery.json',
				'dist/js/jquery.js',
				'dist/js/superfish.min.js'
			]
		);
		self::removeMultiple($vendors . 'jquery/plugins/tablesorter',
			[
				'addons',
				'beta-testing',
				'css',
				'dist',
				'tablesorter.jquery.json',
				'test.html',
				'js/widgets/widget-alignChar.js',
				'js/widgets/widget-build-table.js',
				'js/widgets/widget-chart.js',
				'js/widgets/widget-columns.js',      //in jquery.tablesorter.widgets.js
				'js/widgets/widget-editable.js',
				'js/widgets/widget-filter.js',      //in jquery.tablesorter.widgets.js
				'js/widgets/widget-filter-formatter-html5.js',
				'js/widgets/widget-filter-formatter-select2.js',
				'js/widgets/widget-headerTitles.js',
				'js/widgets/widget-math.js',
				'js/widgets/widget-output.js',
				'js/widgets/widget-print.js',
				'js/widgets/widget-reflow.js',
				'js/widgets/widget-repeatheaders.js',
				'js/widgets/widget-resizable.js',       //in jquery.tablesorter.widgets.js
				'js/widgets/widget-saveSort.js',        //in jquery.tablesorter.widgets.js
				'js/widgets/widget-scroller.js',
				'js/widgets/widget-stickyHeaders.js',   //in jquery.tablesorter.widgets.js
				'js/widgets/widget-storage.js',         //in jquery.tablesorter.widgets.js
				'js/widgets/widget-uitheme.js'          //in jquery.tablesorter.widgets.js
			]
		);
		self::removeMultiple($vendors . 'jquery/plugins/treetable',
			[
				'javascripts/test',
				'stylesheets/jquery.treetable.theme.default.css',
				'stylesheets/screen.css',
				'treetable.jquery.json'
			]
		);
		self::removeMultiple($vendors . 'jquery/plugins/zoom',
			[
				'jquery.zoom.min.js',
				'zoom.jquery.json',
				'demo.html',
				'daisy.jpg',
				'roxy.jpg'
			]
		);
		self::removeMultiple($vendors . 'mediumjs/mediumjs', ['src', 'medium.min.js']);
		$fs->remove($vendors . 'phpcas/phpcas/CAS-1.3.2/docs');
		$fs->remove($vendors . 'phpseclib/phpseclib/tests');
		self::removeMultiple($vendors . 'player',
			[
				'flv/base',
				'flv/classes',
				'flv/html5',
				'flv/mtasc',
				'flv/template_js',
				'flv/template_maxi',
				'flv/template_mini',
				'flv/template_multi',
				'mp3/classes',
				'mp3/mtasc',
				'mp3/template_js',
				'mp3/template_maxi',
				'mp3/template_mini',
				'mp3/template_multi',
			]
		);
		self::removeMultiple($vendors . 'rangy/rangy',
			[
				'uncompressed/rangy-highlighter.js',
				'uncompressed/rangy-serializer.js',
				'uncompressed/rangy-textrange.js',
				'rangy-core.js',
				'rangy-cssclassapplier.js',
				'rangy-highlighter.js',
				'rangy-selectionsaverestore.js',
				'rangy-serializer.js',
				'rangy-textrange.js',
			]
		);
		$fs->remove($vendors . 'smarty/smarty/distribution/demo');
		$fs->remove($vendors . 'twitter/bootstrap/docs');
		$fs->remove($vendors . 'zetacomponents/base/design');
		$fs->remove($vendors . 'zetacomponents/webdav/design');

		// These are removed to avoid composer warnings caused by classes declared in multiple locations
		$fs->remove($vendors . 'adodb/adodb/datadict/datadict');
		$fs->remove($vendors . 'adodb/adodb/session/session');
		$fs->remove($vendors . 'adodb/adodb/perf/perf');
		$fs->remove($vendors . 'adodb/adodb/drivers/drivers');
		$fs->remove($vendors . 'adodb/adodb/adodb-active-recordx.inc.php');
		$fs->remove($vendors . 'adodb/adodb/drivers/adodb-informix.inc.php');
		$fs->remove($vendors . 'adodb/adodb/perf/perf-informix.inc.php');
		$fs->remove($vendors . 'adodb/adodb/datadict/datadict-informix.inc.php');

		// html5shiv uses a component installer that doesn't seem to be optional, so delete the spare copy we end up with.
		$fs->remove($vendors . '../components');
		// and cwspear/bootstrap-hover-dropdown includes bootstrap and jquery without asking
		$fs->remove($vendors . 'components');
	}

	private static function addIndexFile($path)
	{
		if (file_exists($path) || !is_writable($path)) {
			return;
		}

		file_put_contents($path . 'index.php', '<?php header("location: ../index.php"); die;');
	}

	private static function removeStandard ($base)
	{
		$fs = new FileSystem;
		foreach (self::$vendorDirs as $dir) {
			if (is_dir($base . $dir)) {
				foreach (self::$standardFiles as $file) {
					$path = $base . $dir . '/' . $file;
					if (file_exists($path) || is_dir($path)) {
						$fs->remove($path);
					}
				}
			}
		}
	}

	private static function removeMultiple ($base, array $files)
	{
		$fs = new FileSystem;
		foreach ($files as $file) {
			$path = $base . '/' . $file;
			if (file_exists($path) || is_dir($path)) {
				$fs->remove($path);
			}
		}
	}
}


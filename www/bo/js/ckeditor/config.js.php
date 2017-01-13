<?php header('Content-Type: text/javascript; charset=UTF-8'); ?>


/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// File browser
	config.filebrowserBrowseUrl = '<?php echo $_GET['base'] ?>/js/simogeo/index.html';
	config.filebrowserImageBrowseLinkUrl = '<?php echo $_GET['base'] ?>/js/simogeo/index.html';
	config.filebrowserImageBrowseUrl = '<?php echo $_GET['base'] ?>/js/simogeo/index.html';
	config.filebrowserFlashBrowseUrl = '<?php echo $_GET['base'] ?>/js/simogeo/index.html';


	config.pasteFromWordPromptCleanup = true;
	config.pasteFromWordNumberedHeadingToList = true;
	config.forcePasteAsPlainText = true;

	config.toolbar_default =
	[
		    ['Cut','Copy','Paste', '-', 'Undo','Redo'],
		    ['Bold','Italic', 'Subscript','Superscript'],
		    ['NumberedList','BulletedList'],
		    ['Link', 'Image'],
		    ['SpecialChar'],
		    ['Styles', 'RemoveFormat'],
		    ['Source','ShowBlocks','Maximize'],
		    ['tools', 'Source'],
	];

	config.toolbar_cms_blocks =
	[
		    ['Cut','Copy','Paste', '-', 'Undo','Redo'],
		    ['Bold','Italic', 'Subscript','Superscript'],
		    ['NumberedList','BulletedList'],
		    ['Link'],
		    ['SpecialChar'],
		    ['ShowBlocks','Maximize', 'Source'],
	];

	config.toolbar_basic =
	[
		['Bold','Italic', 'Subscript','Superscript']
	];

	config.toolbar_basicLink =
	[
		['Bold','Italic', 'Subscript','Superscript', 'Link', 'Unlink']
	];

	config.toolbar_table =
	[
		['Table']
	];


	//config.allowedContent = 'p[style];h1[class,style];h2[class,style];h3[class,style];h4[class,style];h5[class,style];h6[class,style];a[*];ul;li;ol;strong;em;blockquote;div[class,style];img[*]';
	config.allowedContent = true;


	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};

/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.filebrowserUploadUrl = '../ckupload.php';

	config.toolbar =[
            ['Font','FontSize', 'Bold','Italic','Underline','Strike','-', 'Blockquote', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['TextColor','BGColor'],
            ['customimage','customsmiley','Link','Image','Table'],
            ['NumberedList','BulletedList', 'HorizontalRule'],
            ['-','Source'],
            ['Maximize']
            ];
};

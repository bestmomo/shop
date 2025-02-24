<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

return [
	'config' => [
		'language'       => env('APP_TINYMCE_LOCALE', 'en_US'),
		'plugins'        => 'fullscreen',
		'toolbar'        => 'undo redo style | fontfamily fontsize | alignleft aligncenter alignright alignjustify | bullist numlist | copy cut paste pastetext | hr | link image quicktable | fullscreen',
		'toolbar_sticky' => true,
		'min_height'     => 50,
		'license_key'    => 'gpl',
		'valid_elements' => '*[*]',
	],
	'config_page' => [
		'language'       => env('APP_TINYMCE_LOCALE', 'en_US'),
		'plugins'        => 'codesample fullscreen',
		'toolbar'        => 'undo redo style | fontfamily fontsize | alignleft aligncenter alignright alignjustify | bullist numlist | copy cut paste pastetext | hr | codesample | link image quicktable | fullscreen',
		'toolbar_sticky' => true,
		'min_height'     => 500,
		'license_key'    => 'gpl',
		'valid_elements' => '*[*]',
	],
];

<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: Guide.php
	// The structure of serviz's routing

return [
	'MAGIC_MENU' => [
		'default_permission' => 0,
		'items' => [
			
		],
		'simple_links' => [

		],
	],
	
	
	'auth' => [
		'page_title' => 'Login',
		'default_section' => 'login',
		'arguments' => [
			0 => 'section',
			1 => 'id',
		],
		'menu' => '',
	],

	'assistant' => [
		'page_title' => 'Assistant',
		'default_section' => 'default',
		'arguments' => [
			0 => 'section',
			1 => 'action',
			2 => 'id',
		],
		'menu' => 'dictionary-admin',
	],

	'survey' => [
		'page_title' => 'Survey',
		'default_section' => 'ask',
		'override_structure_type' => 'pAssistantStructure',
		'arguments' => [
			0 => 'section',
			1 => 'action',
			2 => 'id',
		],
		'menu' => 'dictionary-admin',
	],

	'manage' => [
		'page_title' => 'manage',
		'default_section' => 'words',
		'override_structure_type' => 'pAdminStructure',
		'arguments' => [
			0 => 'section',
			1 => 'action',
			2 => 'id',
		],
		'menu' => 'dictionary-admin',
	],


	'MAGIC_MARKDOWN' => [
		
	],

	'MAGIC_MARKDOWN_TITLES' => [
		
	],

	'MAGIC_MARKDOWN_APPS' => [
		
	], 
];
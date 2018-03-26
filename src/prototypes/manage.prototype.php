<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: rulesheet.struct.php
	// The structure of the rule file system

$saveStrings = [null, SAVE, SAVING, SAVED_EMPTY, SAVED_ERROR, SAVED, SAVE_LINKBACK];
$action_remove = ['remove', DA_DELETE, 'fa-trash', 'ttip-sub', null, null];
$action_edit = ['edit', DA_EDIT, 'fa-edit', 'ttip-sub', null, null];

return [
		'MAGIC_META' => [
			'title' => DA_TITLE,
			'icon' => 'fa-list',
			'default_permission' => -3,
		],
		'words' => [
			'section_key' => 'words',
			'menu' => '',
			'icon' => 'source-commit-end-local',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => DA_LEXCAT_TITLE,
			'condition' => false,
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 20,
			'disable_pagination' => false,
			'table' => 'survey_words',
			'datafields' => [
				new pDataField('word', DA_LEXCAT_NAME, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('internID', DA_LEXCAT_NAME, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('language', DA_GRAMCAT, '10%', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_languages', null, 'language_name', true, 'languages')),
				new pDataField('audiofile', DA_ABBR, 'auto', 'input', true, true, true, 'tooltip medium em', false),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', DA_LEXCAT_ADD, 'fa-plus-circle fa-12', 'btAction no-float small', null, null],
			],
			'save_strings' => $saveStrings,
		],
		'languages' => [
			'section_key' => 'languages',
			'menu' => '',
			'icon' => 'translate',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => MANAGE_LANG_SURVEY,
			'condition' => false,
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 7,
			'disable_pagination' => false,
			'table' => 'survey_languages',
			'datafields' => [
				new pDataField('language_name', MANAGE_LANG_NAME, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('language_locale', MANAGE_LANG_LOCALE, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('choosable', MANAGE_LANG_CHOOSABLE, 'auto', 'boolean', true, true, true, '', true),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', MANAGE_LANG_NEW, 'fa-plus-circle fa-12', 'btAction no-float small', null, null],
			],
			'save_strings' => $saveStrings,
		],
		'versions' => [
			'section_key' => 'versions',
			'menu' => '',
			'icon' => 'fa-code-branch',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => MANAGE_VER_SURVEY,
			'condition' => false,
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 7,
			'disable_pagination' => false,
			'table' => 'survey_versions',
			'datafields' => [
				new pDataField('internName', MANAGE_VER_NAME, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('usageCount', MANAGE_VER_CNT, 'auto', 'input', true, true, true, 'medium', false),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', MANAGE_VER_NEW, 'fa-plus-circle fa-12', 'btAction no-float small', null, null],
			],
			'save_strings' => $saveStrings,
		],
		'translations' => [
			'section_key' => 'translations',
			'menu' => '',
			'icon' => 'approval',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => MANAGE_TRANS_SURVEY,
			'condition' => false,
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 7,
			'disable_pagination' => false,
			'table' => 'survey_correct_translations',
			'datafields' => [
				new pDataField('translation', MANAGE_TRANS_TRANS, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('survey_word', MANAGE_TRANS_WORD, '10%', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_words', null, 'internID', true, 'words')),
				new pDataField('language', MANAGE_TRANS_LANG, '10%', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_languages', null, 'language_name', true, 'languages')),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', MANAGE_VER_NEW, 'fa-plus-circle fa-12', 'btAction no-float small', null, null],
			],
			'save_strings' => $saveStrings,
		],
	];
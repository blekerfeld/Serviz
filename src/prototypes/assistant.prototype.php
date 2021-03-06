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
			'default_permission' => 0,
		],
		'default' => [
			'section_key' => 'default',
			'permission' => 0,
			'icon' => 'fa-circle-o',
			'type' => 'pAssistantHandler',
			'view' => 'pAssistantView',
			'table' => 'config',
			'surface' => "",
			'condition' => false,
			'disable_enter' => true,
			'items_per_page' => 20,
			'disable_pagination' => true,
			'actions_item' => [],
			'actions_bar' => [],
			'save_strings' => $saveStrings,
		],
		'revise' => [
			'section_key' => 'revise',
			'permission' => -3,
			'icon' => new pIcon('translate', 24),
			'type' => 'pRevisionAssistantHandler',
			'view' => 'pRevisionView',
			'table' => 'survey_answers',
			'surface' => "Revise",
			'is_admin' => true,
			'is_assistant' => true,
			'desc' => BATCH_TRANSLATE_DESC,
			'condition' => false,
			'disable_enter' => true,
			'items_per_page' => 20,
			'disable_pagination' => true,
			'actions_item' => [],
			'actions_bar' => [],
			'save_strings' => $saveStrings,
		]
	];
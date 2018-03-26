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
		'ask' => [
			'section_key' => 'ask',
			'permission' => 0,
			'icon' => new pIcon('translate', 24),
			'type' => 'pBackgroundHandler',
			'view' => 'pBackgroundView',
			'is_admin' => false,
			'is_assistant' => true,
			'table' => 'survey_background_questions',
			'surface' => BATCH_TRANSLATE_LONG,
			'desc' => BATCH_TRANSLATE_DESC,
			'condition' => false,
			'disable_enter' => true,
			'items_per_page' => 20,
			'disable_pagination' => true,
			'actions_item' => [],
			'actions_bar' => [],
			'save_strings' => $saveStrings,
		],
		'do' => [
			'section_key' => 'do',
			'permission' => 0,
			'icon' => new pIcon('translate', 24),
			'type' => 'pTranslationTaskHandler',
			'view' => 'pTranslationTaskView',
			'table' => 'survey_words',
			'surface' => BATCH_TRANSLATE_LONG,
			'desc' => BATCH_TRANSLATE_DESC,
			'condition' => false,
			'is_admin' => false,
			'is_assistant' => true,
			'disable_enter' => true,
			'items_per_page' => 20,
			'disable_pagination' => true,
			'actions_item' => [],
			'actions_bar' => [],
			'save_strings' => $saveStrings,
		],
	];
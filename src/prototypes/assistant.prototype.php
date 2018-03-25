<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: rulesheet.struct.php
	// The structure of the rule file system


$saveStrings = array(null, SAVE, SAVING, SAVED_EMPTY, SAVED_ERROR, SAVED, SAVE_LINKBACK);

return array(
		'MAGIC_META' => array(
			'title' => DA_TITLE,
			'icon' => 'fa-list',
			'default_permission' => 0,
		),
		'default' => array(
			'section_key' => 'default',
			'permission' => 0,
			'icon' => 'fa-circle-o',
			'type' => 'pAssistantHandler',
			'view' => 'pView',
			'table' => 'config',
			'surface' => "",
			'condition' => false,
			'disable_enter' => true,
			'items_per_page' => 20,
			'disable_pagination' => true,
			'actions_item' => array(
				
			),
			'actions_bar' => array(
				
			),
			'save_strings' => $saveStrings,
		),
		'background' => array(
			'section_key' => 'background',
			'permission' => 0,
			'icon' => new pIcon('translate', 24),
			'type' => 'pAssistantHandler',
			'view' => 'pView',
			'table' => 'survey_background_questions',
			'surface' => BATCH_TRANSLATE_LONG,
			'desc' => BATCH_TRANSLATE_DESC,
			'condition' => false,
			'disable_enter' => true,
			'items_per_page' => 20,
			'disable_pagination' => true,
			'actions_item' => array(
				
			),
			'actions_bar' => array(
				
			),
			'save_strings' => $saveStrings,
		),
		'translate' => array(
			'section_key' => 'translate',
			'permission' => 0,
			'icon' => new pIcon('translate', 24),
			'type' => 'pAssistantHandler',
			'view' => 'pView',
			'table' => 'words',
			'surface' => BATCH_TRANSLATE_LONG,
			'desc' => BATCH_TRANSLATE_DESC,
			'condition' => false,
			'disable_enter' => true,
			'items_per_page' => 20,
			'disable_pagination' => true,
			'actions_item' => array(
				
			),
			'actions_bar' => array(
				
			),
			'save_strings' => $saveStrings,
		),
		'revise' => array(
			'section_key' => 'revise',
			'permission' => -3,
			'icon' => new pIcon('translate', 24),
			'type' => 'pAssistantHandler',
			'view' => 'pView',
			'table' => 'words',
			'surface' => "Revise",
			'desc' => BATCH_TRANSLATE_DESC,
			'condition' => false,
			'disable_enter' => true,
			'items_per_page' => 20,
			'disable_pagination' => true,
			'actions_item' => array(
				
			),
			'actions_bar' => array(
				
			),
			'save_strings' => $saveStrings,
		),
	);
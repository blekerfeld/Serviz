<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: rulesheet.struct.php
	// The structure of the rule file system

$saveStrings = [null, SAVE, SAVING, SAVED_EMPTY, SAVED_ERROR, SAVED, SAVE_LINKBACK];
$action_remove = ['remove', '', 'fa-times', 'btAction subtle medium no-float', null, null];
$action_edit = ['edit', '', 'fa-edit', 'btAction subtle medium no-float', null, null];

return [
		'MAGIC_META' => [
			'title' => DA_TITLE,
			'icon' => 'fa-list',
			'default_permission' => -3,
		],


		'overview' => [
			'section_key' => 'overview',
			'permission' => -3,
			'icon' => 'pulse',
			'type' => 'pStatsHandler',
			'view' => 'pRevisionView',
			'table' => 'survey_answers',
			'surface' => SURVEY_OVERVIEW,
			'is_admin' => true,
			'is_assistant' => true,
			'condition' => false,
			'disable_enter' => true,
			'items_per_page' => 20,
			'disable_pagination' => true,
			'actions_item' => [],
			'actions_bar' => [],
			'save_strings' => $saveStrings,
		],

		'slides' => [
			'section_key' => 'slides',
			'menu' => '',
			'icon' => 'presentation',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => MANAGE_S_TITLE,
			'condition' => (isset(pRegister::arg()['activeSurvey']) ? " WHERE is_slide = 1 AND survey_id = '".pRegister::arg()['activeSurvey']."' " : ""),
			'order' => " language ASC, sorter ASC ",
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 20,
			'disable_pagination' => false,
			'table' => 'survey_background_questions',
			'datafields' => [
				new pDataField('internID', MANAGE_STIM_ID, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('slideText', MANAGE_S_TEXT, 'auto', 'markdown-hide', true, true, false, 'tooltip medium em', false),
				new pDataField('language', MANAGE_LANG_REF, 'auto', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_languages', null, 'language_name', true, 'languages')),
				new pDataField('force_noButtons', MANAGE_S_BUTTONS, '16%', 'boolean-revert', true, true, true, '', true),

				new pDataField('doneStatus', MANAGE_BQ_SHOWBEFORE, 'auto', 'boolean-revert', true, true, true, '', true),

				new pDataField('survey_id', '', 'auto', 'hidden', false, true, false, 'medium', false, @pRegister::arg()['activeSurvey']),


				new pDataField('sorter', MANAGE_STIM_SORT, '15%', 'number', true, true, false, 'tooltip medium em', false),


				new pDataField('is_slide', '', 'auto', 'hidden', false, true, false, 'medium', false, '1'),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', MANAGE_S_ADD, 'plus-outline', 'btAction no-float medium', null, null],
			],
			'save_strings' => $saveStrings,
		],


		'background' => [
			'section_key' => 'background',
			'menu' => '',
			'icon' => 'comment-question-outline',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => MANAGE_BQ_TITLE,
			'condition' => (isset(pRegister::arg()['activeSurvey']) ? " WHERE is_slide = 0 AND survey_id = '".pRegister::arg()['activeSurvey']."' " : ""),
			'order' => " language ASC, sorter ASC ",
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 20,
			'disable_pagination' => false,
			'table' => 'survey_background_questions',
			'datafields' => [
				new pDataField('internID', MANAGE_STIM_ID, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('language', MANAGE_LANG_REF, 'auto', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_languages', null, 'language_name', true, 'languages')),
				new pDataField('question', MANAGE_BQ_Q, 'auto', 'input', true, true, true, 'medium', false),


				new pDataField('type', SURVEY_Q_TYPE, '15%', 'inputtype', true, true, false, 'tooltip medium em', false),

				new pDataField('sorter', MANAGE_STIM_SORT, '15%', 'number', true, true, false, 'tooltip medium em', false),

				new pDataField('doneStatus', MANAGE_BQ_SHOWBEFORE, '20%', 'boolean-revert', true, true, true, '', true),

				new pDataField('survey_id', '', 'auto', 'hidden', false, true, false, 'medium', false, @pRegister::arg()['activeSurvey']),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', MANAGE_BQ_ADD, 'plus-outline', 'btAction no-float medium', null, null],
			],
			'save_strings' => $saveStrings,
		],


		'dropdowns' => [
			'section_key' => 'dropdowns',
			'menu' => '',
			'icon' => 'arrow-expand-down',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => MANAGE_DD_TITLE,
			'condition' => (isset(pRegister::arg()['activeSurvey']) ? " WHERE survey_id = '".pRegister::arg()['activeSurvey']."' " : ""),
			'order' => ' dropdown_id ASC ',
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 20,
			'disable_pagination' => false,
			'table' => 'survey_background_dropdown_options',
			'datafields' => [
				new pDataField('dropdown_id', MANAGE_DD_ID, 'auto', 'input', true, true, true, 'medium tooltip em', false),
				new pDataField('dropdown_option', MANAGE_DD_OPTION, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('dropdown_value', MANAGE_DD_VALUE, 'auto', 'input', true, true, true, 'medium', false),
				((new pDataField('survey_id', '', 'auto', 'hidden', false, true, false, 'medium', false, @pRegister::arg()['activeSurvey']))),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', MANAGE_DD_ADD, 'fa-plus-circle fa-12', 'btAction no-float small', null, null],
			],
			'save_strings' => $saveStrings,
		],


		'stimuli' => [
			'section_key' => 'stimuli',
			'menu' => '',
			'icon' => 'shape',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => SURVEY_STIMULI,
			'condition' => (isset(pRegister::arg()['activeSurvey']) ? " WHERE survey_id = '".pRegister::arg()['activeSurvey']."' " : ""),
			'order' => " sorter ASC ",
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 10,
			'disable_pagination' => false,
			'table' => 'survey_words',
			'datafields' => [
				new pDataField('internID', MANAGE_STIM_ID, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('language', MANAGE_LANG_REF, 'auto', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_languages', null, 'language_name', true, 'languages')),
				new pDataField('survey_word_group', MANAGE_STIM_GROUP, 'auto', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_word_groups', null, 'word_group_name', true, 'stimulusgroups')),
				new pDataField('survey_version', MANAGE_VER_REF, 'auto', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_versions', null, 'internName', true, 'versions')),
				new pDataField('word', MANAGE_STIM_SHOWWORD, 'auto', 'input', true, true, false, 'tooltip medium em', false),
				new pDataField('audiofile', MANAGE_STIM_PLAYSOUND, 'auto', 'audiofile', true, true, false, 'tooltip medium em', false),
				new pDataField('sorter', MANAGE_STIM_SORT, 'auto', 'number', true, true, false, 'tooltip medium em', false),
				new pDataField('survey_id', '', 'auto', 'hidden', false, true, false, 'medium', false, @pRegister::arg()['activeSurvey']),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', MANAGE_STIM_ADD, 'shape-plus', 'btAction no-float medium', null, null],
			],
			'save_strings' => $saveStrings,
		],


		'stimulusgroups' => [
			'section_key' => 'stimulusgroups',
			'menu' => '',
			'icon' => 'group',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => MANAGE_STIM_GROUPS,
			'condition' => (isset(pRegister::arg()['activeSurvey']) ? " WHERE survey_id = '".pRegister::arg()['activeSurvey']."' " : ""),
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 7,
			'disable_pagination' => false,
			'table' => 'survey_word_groups',
			'datafields' => [
				new pDataField('word_group_name', MANAGE_STIM_GROUPS_NAME, 'auto', 'input', true, false, false, 'medium', false),
				new pDataField('internID', MANAGE_STIM_ID, 'auto', 'input', true, true, true, 'medium tooltip em', false),
				new pDataField('language', MANAGE_LANG_REF, 'auto', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_languages', null, 'language_name', true, 'languages')),
				((new pDataField('survey_id', '', 'auto', 'hidden', false, true, false, 'medium', false, @pRegister::arg()['activeSurvey']))),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', MANAGE_STIM_GROUPS_ADD, 'fa-plus-circle fa-12', 'btAction no-float small', null, null],
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
				new pDataField('survey_word', MANAGE_TRANS_WORD, '10%', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_words', null, 'internID', true, 'stimuli')),
				new pDataField('language', MANAGE_TRANS_LANG, '10%', 'select', true, true, true, 'small-caps xxxsmall', false, new pSelector('survey_languages', null, 'language_name', true, 'languages')),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', MANAGE_TRANS_ADD, 'fa-plus-circle fa-12', 'btAction no-float small', null, null],
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
			'condition' => (isset(pRegister::arg()['activeSurvey']) ? " WHERE survey_id = '".pRegister::arg()['activeSurvey']."' " : ""),
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 7,
			'disable_pagination' => false,
			'table' => 'survey_versions',
			'datafields' => [
				new pDataField('internName', MANAGE_VER_NAME, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('usageCount', MANAGE_VER_CNT, 'auto', 'input', true, false, false, 'medium', false),
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

		'languages' => [
			'section_key' => 'languages',
			'menu' => '',
			'icon' => 'translate',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => MANAGE_LANG_SURVEY,
			'condition' => (isset(pRegister::arg()['activeSurvey']) ? " WHERE survey_id = '".pRegister::arg()['activeSurvey']."' " : ""),
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 10,
			'disable_pagination' => false,
			'table' => 'survey_languages',
			'datafields' => [
				new pDataField('language_name', MANAGE_LANG_NAME, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('language_locale', MANAGE_LANG_LOCALE, 'auto', 'input', true, true, true, 'medium', false),
				new pDataField('choosable', MANAGE_LANG_CHOOSABLE, 'auto', 'boolean', true, true, true, '', true),
				((new pDataField('survey_id', '', 'auto', 'hidden', false, true, false, 'medium', false, @pRegister::arg()['activeSurvey']))),
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
		'strings' => [
			'section_key' => 'strings',
			'menu' => '',
			'icon' => 'tag-text-outline',
			'type' => 'pTableHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => SURVEY_STRINGS,
			'condition' => (isset(pRegister::arg()['activeSurvey']) ? " WHERE survey_id = '".pRegister::arg()['activeSurvey']."' " : ""),
			'is_admin' => true,
			'is_assistant' => false,
			'items_per_page' => 10,
			'disable_pagination' => false,
			'table' => 'survey_languages',
			'datafields' => [
				new pDataField('language_name', MANAGE_LANG_NAME, 'auto', 'hidden-show', true, true, true, 'medium', false),
				new pDataField('strChoose', SURVEY_STR_CHOOSE, 'auto', 'input', true, true, false, 'medium', false),
				new pDataField('strTranslate', SURVEY_STR_TRANSLATE, 'auto', 'input', true, true, false, 'medium', false),
				new pDataField('strBack', SURVEY_STR_BACK, 'auto', 'input', true, true, false, 'medium', false),
				new pDataField('strNext', SURVEY_STR_NEXT, 'auto', 'input', true, true, false, 'medium', false),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
			],
			'save_strings' => $saveStrings,
		],
		
		'surveys' => [
			'section_key' => 'surveys',
			'menu' => '',
			'icon' => 'clipboard-pulse-outline mdi-17',
			'type' => 'pMySurveysHandler',
			'desc' => '',
			'view' => 'pView',
			'surface' => SURVEY_MY,
			'condition' => " WHERE user_id = '".pUser::read('id')."' ",
			'is_admin' => true,
			'is_assistant' => false,
			'id_as_hash' => true,
			'hash_app' => 'survey',
			'items_per_page' => 7,
			'disable_pagination' => false,
			'table' => 'surveys',
			'datafields' => [
				new pDataField('survey_name', SURVEY_NAME, 'auto', 'input', true, true, true, 'mmedium', false),
				new pDataField('survey_logo', SURVEY_LOGO, 'auto', 'input', false, true, false, 'medium', false),
				new pDataField('survey_status', SURVEY_OPEN, 'auto', 'boolean', true, true, true, '', true),
				((new pDataField('user_id', '', 'auto', 'hidden', false, true, false, 'medium', false, pUser::read('id')))),
			],
			'actions_item' => [
				'edit' => $action_edit,
				'remove' => $action_remove,
			],
			'actions_bar' => [
				'new' => ['new', SURVEY_ADD, 'clipboard-plus mdi-17', 'btAction no-float', null, null],
			],
			'save_strings' => $saveStrings,
		],

	];
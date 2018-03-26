<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: EntryObject.class.php

//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pBackgroundHandler extends pAssistantHandler{

	public $_view, $_rulesheetModel;


	public function render($ajax = false){
		$this->_view = new $this->_activeSection['view']($this, $this->_section);
		return $this->_view->render($this->_section, [], $ajax);
	}

	public function getData($id = -1){

		$this->_dataModel = new pDataModel('survey_background_questions');
		if(isset($_SESSION['btChooser-background']))
			$this->_data = $this->_dataModel->complexQuery("SELECT * FROM survey_background_questions WHERE doneStatus = ".(isset($_SESSION['btDone']) ? '1' : '0')." AND language = '".$_SESSION['btChooser-background']."' AND id NOT IN ( '" . @implode($_SESSION['btSkip-background'], "', '") . "' ) ORDER BY  sorter ASC LIMIT 1;")->fetchAll();
		else
			$this->_data = [0];
		
		return false;
	}

	public function serveCard(){

		if(isset($this->_data[0]))
		 	return $this->_view->cardBackground($this->_data[0], $this->_section);
		 elseif(!isset($_SESSION['btDone'])){
		 	// We want to move to translate now! 
		 	$_SESSION['btChooser-translate'] = 0;
	 		echo "<script>loadTranslate();</script>";
		 }
		 else{
		 	(new pDataModel('survey_sessions'))->complexQuery("UPDATE survey_sessions SET doneStatus = '1' WHERE id = ".$_SESSION['btSurveyID']);
		 	$this->ajaxReset();
		 }

	}

	
	public function ajaxHandle(){
		// Make this somehting else
		$_SESSION['btSkip-background'][] = $this->_data[0]['id'];

		(new pDataModel('survey_background_answers'))->prepareForInsert([$_SESSION['btSurveyID'], $this->_data[0]['id'], pRegister::post()['answer']])->cleanCache('survey_questions_answers')->insert();

	}


	

	public function ajaxNever(){
		$dM = new pDataModel('translation_exceptions');
		$dM->prepareForInsert(array(pRegister::post()['never'], $_SESSION['btChooser-translate'], pUser::read('id')));
		$dM->insert();
		$dM->cleanCache('words');
	}

	public function ajaxSetSession(){
		// Let's create a session as well
		// Assign the version that is least used up untill now! :) 
		$_SESSION['btSurveyVersion'] = (new pDataModel('survey_versions'))->complexQuery("SELECT id FROM survey_versions ORDER BY usageCount ASC LIMIT 1;")->fetchAll()[0]['id'];
		(new pDataModel('survey_versions'))->complexQuery("UPDATE survey_versions SET usageCount = usageCount + 1 WHERE id = " . $_SESSION['btSurveyVersion']);
		$_SESSION['btSurveyID'] = (	new pDataModel('survey_sessions'))->prepareForInsert([$this->getUserIP(), 'Somewhere', pRegister::post()['btChooser'], 'NOW()', '0', $_SESSION['btSurveyVersion']])->insert();

		$_SESSION['btChooser-translate'] = 0;
		$_SESSION['btSkip-'.$this->_section] = array();
		return pRegister::session('btChooser-'.$this->_section, pRegister::post()['btChooser']);
	}

	
}
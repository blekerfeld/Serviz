<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: EntryObject.class.php

//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pBackgroundHandler extends pAssistantHandler{

	public $_view, $_rulesheetModel;

	public function getData($id = -1){

		$this->_dataModel = new pDataModel('survey_background_questions');

		if(isset($_SESSION['btChooser-ask']))
			$this->_data = $this->_dataModel->complexQuery("SELECT * FROM survey_background_questions WHERE survey_id = '".$this->_surveyID."' AND doneStatus = ".(isset($_SESSION['btDone']) ? '1' : '0')." AND language = '".$_SESSION['btChooser-ask']."' AND id NOT IN ( '" . @implode($_SESSION['btSkip-ask'], "', '") . "' ) ORDER BY sorter ASC LIMIT 1;")->fetchAll();
		else
			$this->_data = [0];
		
		return false;
	}


	public function serveCard(){

		if(isset($this->_data[0]))
		 	return $this->_view->cardBackground($this->_data[0], $this->_section);
		 elseif(!isset($_SESSION['btDone'])){
		 	// We want to move to translate now! 
		 	$_SESSION['btChooser-do'] = 0;
	 		echo "<script>loadTranslate();</script>";
		 }
		 else{
		 	(new pDataModel('survey_sessions'))->complexQuery("UPDATE survey_sessions SET doneStatus = '1', doneStatus = '1' AND date_completed = NOW() WHERE id = ".$_SESSION['btSurveyID']);
		 	$this->ajaxReset();
		 }

	}

	
	public function ajaxHandle(){
		// Make this somehting else
		$_SESSION['btSkip-ask'][] = $this->_data[0]['id'];
		$answer = pRegister::post()['answer'];
		if(is_array($answer))
			$answer = implode('; ', $answer);
		(new pDataModel('survey_background_answers'))->prepareForInsert([$_SESSION['btSurveyID'], $this->_data[0]['id'], $answer])->cleanCache('survey_questions_answers')->insert();

	}


	

	public function ajaxNever(){
		$dM = new pDataModel('translation_exceptions');
		$dM->prepareForInsert(array(pRegister::post()['never'], $_SESSION['btChooser-do'], pUser::read('id')));
		$dM->insert();
		$dM->cleanCache('words');
	}

	public function ajaxSetSession(){
		// Let's create a session as well
		// Assign the version that is least used up untill now! :) 
		$_SESSION['btSurveyVersion'] = (new pDataModel('survey_versions'))->complexQuery("SELECT id FROM survey_versions ORDER BY usageCount ASC LIMIT 1;")->fetchAll()[0]['id'];
		(new pDataModel('survey_versions'))->complexQuery("UPDATE survey_versions SET usageCount = usageCount + 1 WHERE id = " . $_SESSION['btSurveyVersion']);
		$_SESSION['btSurveyID'] = (	new pDataModel('survey_sessions'))->prepareForInsert([$this->getUserIP(), 'Somewhere', pRegister::post()['btChooser'], 'NOW()', 'NOW()', '0', $_SESSION['btSurveyVersion'], $this->_surveyID])->insert();
		$_SESSION['btChooser-do'] = 0;
		$_SESSION['btSkip-'.$this->_section] = array();
		return pRegister::session('btChooser-'.$this->_section, pRegister::post()['btChooser']);
	}

	public function getFeedback(){
		return $this->_dataModel->complexQuery("SELECT SUM(isMatch) AS TotalCorrect, COUNT(sa.id) AS AnswerCount, (SELECT count(id) AS TotalCount FROM survey_words WHERE survey_version = '".$_SESSION['btSurveyVersion']."' AND survey_id = '".$this->_surveyID."') AS TotalCount FROM survey_answers AS sa JOIN survey_sessions AS ss ON ss.id = sa.survey_session WHERE sa.survey_session = '".$_SESSION['btSurveyID']."' AND ss.survey_version = '".$_SESSION['btSurveyVersion']."';")->fetchAll()[0];
	}

	
}
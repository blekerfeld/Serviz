<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: EntryObject.class.php

//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pTranslationTaskHandler extends pAssistantHandler{

	public function getData($id = -1){

		if(isset(pRegister::session()['btChooser-do'])){
			$this->_dataModel = new pDataModel('survey_words');
			$this->_data = $this->_dataModel->complexQuery("SELECT * FROM survey_words WHERE survey_id = '".$this->_surveyID."' AND language != '".$_SESSION['btChooser-ask']."' AND survey_version = '".$_SESSION['btSurveyVersion']."' AND id NOT IN ( '" . @implode($_SESSION['btSkip-do'], "', '") . "' ) ORDER BY sorter ASC LIMIT 1;")->fetchAll();
		}
		
		return false;
	}

	public function ajaxReset(){
		unset($_SESSION['btChooser-do']);
		unset($_SESSION['btSkip-do']);
		unset($_SESSION['btDone']);
	}

	public function serveCard(){
		
		$_SESSION['startedTime'] = time();

		if(isset($this->_data[0]))
		 	return $this->_view->cardTranslate($this->_data[0], $this->_section);
		 else{
		 	$_SESSION['btDone'] = 1;
		 	echo "<script>loadBackground();</script>";
		 	return;
		 }
	}

	public function ajaxHandle(){

		$_SESSION['btSkip-do'][] = $this->_data[0]['id'];
		$correctTranslations = [];
		$wrongTranslations = [];

		$RT = (time() - $_SESSION['startedTime']);

		$checkMatchCorrect = (new pDataModel('survey_correct_translations'))->setCondition(" WHERE internID = '".$this->_data[0]['internID']."' AND language = '".pRegister::session()['btChooser-ask']."' AND survey_id = '".$this->_survey['id']."' ")->getObjects();
		
		$checkMatchWrong = (new pDataModel('survey_wrong_translations'))->setCondition(" WHERE internID = '".$this->_data[0]['internID']."' AND language = '".pRegister::session()['btChooser-ask']."' AND survey_id = '".$this->_survey['id']."' ")->getObjects();

		if($checkMatchCorrect->fetchAll())
			foreach($checkMatchCorrect->fetchAll() as $translation)
				$correctTranslations[] = trim(strtolower($translation['translation']));
		if($checkMatchWrong->fetchAll())
			foreach($checkMatchWrong->fetchAll() as $translation)
				$wrongTranslations[] = trim(strtolower($translation['translation']));

		$data = [$_SESSION['btSurveyID'], $this->_data[0]['id'], $this->_data[0]['survey_word_group'],  pRegister::post()['translation'], ((in_array(trim(strtolower(pRegister::post()['translation'])), $correctTranslations)) ? '1' : '0'), ((in_array(trim(strtolower(pRegister::post()['translation'])), $wrongTranslations)) ? '1' : '0'), $RT];

		(new pDataModel('survey_answers'))->prepareForInsert($data)->cleanCache('survey_questions_answers')->insert();
	
	}
	
}
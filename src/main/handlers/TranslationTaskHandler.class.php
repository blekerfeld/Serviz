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

		$checkMatch = (new pDataModel('survey_correct_translations'))->setCondition(" WHERE survey_word = '".$this->_data[0]['id']."' AND language = '".pRegister::session()['btChooser-ask']."' ")->getObjects();

		if($checkMatch->fetchAll())
			foreach($checkMatch->fetchAll() as $translation)
				$correctTranslations[] = trim(strtolower($translation['translation']));

		(new pDataModel('survey_answers'))->prepareForInsert([$_SESSION['btSurveyID'], $this->_data[0]['id'], $this->_data[0]['survey_word_group'],  pRegister::post()['translation'], ((in_array(trim(strtolower(pRegister::post()['translation'])), $correctTranslations)) ? '1' : '0'), '0'])->cleanCache('survey_questions_answers')->insert();
	}
	
}
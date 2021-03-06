<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: EntryObject.class.php

//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pRevisionAssistantHandler extends pAssistantHandler{

	
	public function renderRevise($ajax = false){
		return $this->_view->render($this->_section, [], $ajax);
	}


	public function getData($id = -1){

		
		if(isset(pRegister::session()['btChooser-revise'])){
			$this->_dataModel = new pDataModel('survey_answers');
			$this->_data = $this->_dataModel->complexQuery("SELECT *, survey_answers.id AS answerID, survey_words.word AS word_native, survey_words.internID as internID_word, survey_words.language AS word_language, survey_sessions.language AS session_lang FROM survey_answers JOIN survey_sessions ON survey_sessions.id = survey_answers.survey_session JOIN survey_words ON survey_words.id = survey_answers.word WHERE answer != '' AND isMatch != 1 AND revised = 0 AND survey_sessions.language = '".$_SESSION['btChooser-revise']."' AND survey_words.survey_id = '".pRegister::arg()['activeSurvey']."' LIMIT 1;")->fetchAll();
		}

		return false;
	}


	public function serveCardRevise(){
		if(isset($this->_data[0]))
		 	return $this->_view->cardRevise($this->_data[0], $this->_section);
		 else
		 	return $this->_view->cardReviseEmpty($this->_section);
	}


	public function ajaxHandleRevise(){
		// Make this somehting else
		$_SESSION['btSkip-revise'][] = $this->_data[0]['answerID'];

		if(pRegister::post()['value'] == '1')
			(new pDataModel('survey_correct_translations'))->complexQuery("INSERT INTO survey_correct_translations (id, language, translation, survey_id, internID) VALUES(NULL, '".$this->_data[0]['session_lang']."', '".$this->_data[0]['answer']."', '".$this->_data[0]['survey_id']."', '".$this->_data[0]['internID_word']."') ;");
		
		if(pRegister::post()['value'] == '0')
			(new pDataModel('survey_wrong_translations'))->complexQuery("INSERT INTO survey_wrong_translations (id, language, translation, survey_id, internID) VALUES(NULL, '".$this->_data[0]['session_lang']."', '".$this->_data[0]['answer']."', '".$this->_data[0]['survey_id']."', '".$this->_data[0]['internID_word']."') ;");
		
		(new pDataModel('survey_answers'))->cleanCache('survey_questions_answers')->complexQuery("UPDATE survey_answers SET isMatch = '" .pRegister::post()['value'] . "', revised = 1 WHERE answer = " . p::Quote($this->_data[0]['answer']).";");
	}

}
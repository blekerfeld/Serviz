<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: TableObject.class.php

class pStatsHandler extends pHandler{
	
	public $_survey, $_sessionsAll, $_sessionsDone, $_time, $_unrevised, $_languages, $_languagesCount = [];

	public function render(){

		if(!isset(pRegister::arg()['activeSurvey']))
			p::Url('?', true);

		if(!$this->_survey = (new pDataModel('surveys'))->getSingleObject(pRegister::arg()['activeSurvey'])->fetchAll()[0])
			p::Url('?', true);

		if(!$this->_sessionsInfo = (new pDataModel('survey_sessions'))->complexQuery("SELECT count(id) AS totalCount, (SELECT count(id) FROM survey_sessions WHERE survey_id = '".$this->_survey['id']."' AND doneStatus = 1) AS doneCount FROM survey_sessions WHERE survey_id = '".$this->_survey['id']."'")->fetchAll()[0])
			p::Url('?', true); 

		if(!$this->_time = (new pDataModel)->complexQuery("SELECT ROUND(AVG( TIMESTAMPDIFF(MINUTE,date_started, date_completed))) AS completionTime FROM survey_sessions WHERE doneStatus = 1;")->fetchAll()[0])
			p::Url('?', true); 		
		
		if(!$this->_unrevised = (new pDataModel)->complexQuery("SELECT count(DISTINCT survey_answers.answer) AS unrevisedCount FROM survey_sessions JOIN survey_answers ON survey_answers.survey_session = survey_sessions.id WHERE survey_sessions.survey_id = ".$this->_survey['id']." AND survey_answers.revised = 0 AND survey_answers.answer != '' AND survey_answers.isMatch = 0;")->fetchAll()[0])
			p::Url('?', true); 		

		if(!$this->_languages = (new pDatamodel)->complexQuery("SELECT * FROM survey_languages WHERE choosable = 1 AND survey_id = '".$this->_survey['id']."';")->fetchAll())
			p::Url('?', true);

		foreach($this->_languages AS $lang)
			$this->_languagesCount[$lang['language_name']] = (new pDataModel)->complexQuery("SELECT count(id) AS cnt FROM survey_sessions WHERE doneStatus = 1 AND survey_id = '".$this->_survey['id']."' AND language = '".$lang['id']."';")->fetchAll()[0]['cnt']; 

		$this->_view = new pStatsView($this);
		$this->_view->render();

	}
}
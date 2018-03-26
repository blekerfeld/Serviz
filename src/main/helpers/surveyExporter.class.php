<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: exportSurvey.class.php

class pSurveyExporter{

	private $_fields = ['id', 'ipadress', 'language', 'total'], $_dM, $_backgroundFields, $_wordFields, $_groupFields, $_rows = [], $_sessions = []; 

	public function __toString(){
		return; 
	}

	// Constructure accepts both a language code or a number
	public function __construct($language, $natLang = 1){
		$this->_dM = (new pDataModel('survey_background_questions'));
		$this->_backgroundFields = $this->_dM->complexQuery("SELECT internID, id FROM survey_background_questions WHERE is_slide = 0 AND language = '".$language."'")->fetchAll();
		foreach($this->_backgroundFields as $bF)
			$this->_fields['bF_' . $bF['id']] = $bF['internID'];
		
		$this->_wordFields = $this->_dM->complexQuery("SELECT internID, id FROM survey_words WHERE language = '".$natLang."'")->fetchAll();
		foreach($this->_wordFields as $wF)
			$this->_fields['wF_' . $wF['id']] = $wF['internID'];

		$this->_groupFields = $this->_dM->complexQuery("SELECT internID, id FROM survey_word_groups WHERE language = '".$natLang."'")->fetchAll();
		foreach($this->_groupFields as $gF)
			$this->_fields['gF_' . $gF['id']] = $gF['internID'] . '_total';

		foreach($this->_dM->complexQuery("SELECT id, ipadress, language FROM survey_sessions WHERE language = '".$language."' AND doneStatus = 1")->fetchAll() as $session)
			$this->_sessions[] = $session;

		foreach($this->_sessions as $session){
			$tempRow = ['id' => $session['id'], 'total' => 0, 'ipadress' => $session['ipadress'], 'language' => $session['language']];

	
			$backgroundAnswers = $this->_dM->complexQuery("SELECT answer, survey_question FROM survey_background_answers WHERE survey_session = '".$session['id']."'")->fetchAll();
			foreach($backgroundAnswers as $bA)
				$tempRow[$this->_fields['bF_'.$bA['survey_question']]] = $bA['answer'];

			$wordAnswers = $this->_dM->complexQuery("SELECT word, word_group, answer, isMatch, revised FROM survey_answers WHERE survey_session = '".$session['id']."'")->fetchAll();

			foreach($this->_groupFields as $gF)
				$tempRow[$this->_fields['gF_'.$gF['id']]] = 0;

			foreach($wordAnswers as $wA){
				$tempRow[$this->_fields['wF_'.$wA['word']]] = ($wA['isMatch'] == 1 ? '1' : ($wA['isMatch'] == 1 ? $wA['isMatch'] : $wA['answer']));
				$tempRow['total'] += $wA['isMatch'];
				$tempRow[$this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
			}

			
			$this->_rows[$session['id']] = $tempRow;
		}

	}


	public function compile(){

		$fp = fopen('file.csv', 'w');

	
		fputcsv($fp, $this->_fields, ';');

		$makeFields = [];

		foreach ($this->_rows as $row){
			$makeFields = [];
			foreach($this->_fields as $field)
				$makeFields[] = $row[$field];
		    fputcsv($fp, $makeFields, ';');
		}

		fclose($fp);
	
	}

}


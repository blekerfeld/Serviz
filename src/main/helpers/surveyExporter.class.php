<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: exportSurvey.class.php

class pSurveyExporter{

<<<<<<< HEAD
	private $_language, $_natLang, $_survey, $_fields = ['id', 'ipadress', 'language', 'total', 'version'], $_dM, $_backgroundFields, $_wordFields, $_groupFields, $_rows = [], $_sessions = [], $_versionNames = [], $_wordAnswers = [], $_backgroundAnswers = []; 
=======
	private $_language, $_natLang, $_survey, $_fields = ['id','_session', 'ipadress', 'language', 'total', 'version'], $_dM, $_backgroundFields, $_wordFields, $_groupFields, $_rows = [], $_sessions = [], $_versionNames = [], $_wordAnswers = [], $_backgroundAnswers = []; 
>>>>>>> parent of 4798c5b... Merge remote-tracking branch 'origin/master'

	public function __toString(){
		return; 
	}

	// Constructure accepts both a language code or a number
	public function __construct($id, $language = null, $natLang = 1){
		$this->_language = ($language != null ? 'language = \'' . $language .'\' AND ' : '');
		$this->_natLang = $natLang;
		$this->_dM = (new pDataModel('surveys'));

		// Let's check whether or not the survey exsists.
		if(!(($check = $this->_dM->complexQuery("SELECT * FROM surveys WHERE id = ".$id)) AND $check->rowCount() != 0 AND $this->_survey = $check->fetchAll()[0]))
			throw new Exception("Nope, this survey does not exist. nope. nope. ");

		// Load ALL the things
		$this->getBackgroundFields();
		$this->getTaskFields();		
		$this->getGroupTotalFields();
		$this->getSessions();
		$this->getVersionNames();
		$this->fetchBackgroundAnswers();
		$this->fetchWordAnswers();
<<<<<<< HEAD

		foreach($this->_sessions as $session){
			// Create a temporary row

			$tempRow = ['id' => $session['id'], 'total' => 0, 'ipadress' => $session['ipadress'], 'language' => $session['language'], 'version' => $this->_versionNames[$session['survey_version']]];
			
			if(isset($this->_backgroundAnswers['s_'.$session['id']]))
				foreach($this->_backgroundAnswers['s_'.$session['id']] as $bA)
					$tempRow[$this->_fields['bF_'.$bA['survey_question']]] = $bA['answer'];
=======
		$this->_fields = array_unique($this->_fields);

		$currentID = 0;

		foreach($this->_sessions as $session){
			$currentID++;
			// Create a temporary row
			$tempRow = ['id' => $currentID, '_session' => $session['id'], 'total' => 0, 'ipadress' => $session['ipadress'], 'language' => $session['language'], 'version' => $this->_versionNames[$session['survey_version']]];
			
			if(isset($this->_backgroundAnswers['s_'.$session['id']]))
				foreach($this->_backgroundAnswers['s_'.$session['id']] as $bA)
					$tempRow[$this->_fields['bF_'.$bA['qii']]] = $bA['answer'];
>>>>>>> parent of 4798c5b... Merge remote-tracking branch 'origin/master'

			foreach($this->_groupFields as $gF)
				$tempRow[$this->_fields['gF_'.$gF['id']]] = 0;

			if(isset($this->_wordAnswers['s_'.$session['id']]))
				foreach($this->_wordAnswers['s_'.$session['id']] as $wA){
<<<<<<< HEAD
					$tempRow[$this->_fields['wF_'.$wA['word']]] = ($wA['isMatch'] == 1 ? '1' : ($wA['isMatch'] == 1 ? $wA['isMatch'] : $wA['answer']));
=======
					$tempRow[$this->_fields['wF_'.$wA['wii']]] = ($wA['isMatch'] == 1 ? '1' : ($wA['isMatch'] == 1 ? $wA['isMatch'] : $wA['answer']));
>>>>>>> parent of 4798c5b... Merge remote-tracking branch 'origin/master'
					$tempRow['total'] += $wA['isMatch'];
					$tempRow[$this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
				}

			// Need to make sure the csv exporter is not going to stress about different words, maybe not existing other versions
			foreach($this->_fields as $field)
				if(!isset($tempRow[$field]))
					$tempRow[$field] = '';

			// Make the temp row less temp.
			$this->_rows[$session['id']] = $tempRow;

		}

	}

	private function fetchBackgroundAnswers(){
<<<<<<< HEAD
		if($fetch = $this->_dM->complexQuery("SELECT * FROM survey_background_answers AS ba JOIN survey_sessions ON ba.survey_session = survey_sessions.id AND survey_sessions.survey_id = '".$this->_survey['id']."';"))
=======
		if($fetch = $this->_dM->complexQuery("SELECT *, bq.internID as qii FROM survey_background_answers AS ba JOIN survey_sessions ON ba.survey_session = survey_sessions.id AND survey_sessions.survey_id = '".$this->_survey['id']."' JOIN survey_background_questions AS bq ON bq.id = ba.survey_question;"))
>>>>>>> parent of 4798c5b... Merge remote-tracking branch 'origin/master'
			foreach($fetch->fetchAll() as $bA)
				$this->_backgroundAnswers['s_'.$bA['survey_session']][] = $bA;
	}

	private function fetchWordAnswers(){
<<<<<<< HEAD
		if($fetch = $this->_dM->complexQuery("SELECT * FROM survey_answers AS ba JOIN survey_sessions ON ba.survey_session = survey_sessions.id AND survey_sessions.survey_id = '".$this->_survey['id']."';"))
=======
		if($fetch = $this->_dM->complexQuery("SELECT *, sw.internID as wii FROM survey_answers AS ba JOIN survey_sessions ON ba.survey_session = survey_sessions.id AND survey_sessions.survey_id = '".$this->_survey['id']."' JOIN survey_words AS sw ON sw.id = ba.word ;"))
>>>>>>> parent of 4798c5b... Merge remote-tracking branch 'origin/master'
			foreach($fetch->fetchAll() as $wA)
				$this->_wordAnswers['s_'.$wA['survey_session']][] = $wA;
	}
	

	private function getSessions(){
		foreach($this->_dM->complexQuery("SELECT id, ipadress, language, survey_version FROM survey_sessions WHERE ".$this->_language." doneStatus = 1")->fetchAll() as $session)
			$this->_sessions[] = $session;
	}

	private function getVersionNames(){
		foreach($this->_dM->complexQuery("SELECT id, internName FROM survey_versions WHERE survey_id = '".$this->_survey['id']."'")->fetchAll() as $ver)
			$this->_versionNames[$ver['id']] = $ver['internName'];
	}

	private function getBackgroundFields(){

		// Get all background fields
		$this->_backgroundFields = $this->_dM->complexQuery("SELECT internID, id FROM survey_background_questions WHERE ".$this->_language." survey_id = '".$this->_survey['id']."' AND is_slide = 0")->fetchAll();
		// Save it in the fields array
		foreach($this->_backgroundFields as $bF)
<<<<<<< HEAD
			$this->_fields['bF_' . $bF['id']] = $bF['internID'];
=======
			$this->_fields['bF_' . $bF['internID']] = $bF['internID'];
>>>>>>> parent of 4798c5b... Merge remote-tracking branch 'origin/master'
	}

	private function getTaskFields(){
		$this->_wordFields = $this->_dM->complexQuery("SELECT internID, id FROM survey_words WHERE survey_id = '".$this->_survey['id']."' AND ".$this->_natLang."")->fetchAll();
		foreach($this->_wordFields as $wF)
<<<<<<< HEAD
			$this->_fields['wF_' . $wF['id']] = $wF['internID'];
=======
			$this->_fields['wF_' . $wF['internID']] = $wF['internID'];
>>>>>>> parent of 4798c5b... Merge remote-tracking branch 'origin/master'
	}

	private function getGroupTotalFields(){
		$this->_groupFields = $this->_dM->complexQuery("SELECT internID, id FROM survey_word_groups WHERE survey_id = '".$this->_survey['id']."' AND ".$this->_natLang."")->fetchAll();
		foreach($this->_groupFields as $gF)
			$this->_fields['gF_' . $gF['id']] = $gF['internID'] . '_total';

	}


	public function compile(){
		$filename = p::FromRoot('/library/output/data-survey-'.md5(trim(preg_replace('/\W+/', '-', strtolower($this->_survey['survey_name']))).rand()).'.csv');
		
		$fp = fopen($filename, 'w');
<<<<<<< HEAD
		
=======
		fwrite($fp, pack("CCC",0xef,0xbb,0xbf)); 		
>>>>>>> parent of 4798c5b... Merge remote-tracking branch 'origin/master'
		fputcsv($fp, $this->_fields, ';');

		$makeFields = [];

		foreach ($this->_rows as $row){
			$makeFields = [];
			foreach($this->_fields as $field)
				$makeFields[] = $row[$field];

		   fputcsv($fp, $makeFields, ';');
		}
		header('Content-Type: application/csv');
   		// tell the browser we want to save it instead of displaying it
    	header('Content-Disposition: attachment; filename="output.csv";');
   		// make php send the generated csv lines to the browser
		echo file_get_contents($filename);

		die();
	}

}

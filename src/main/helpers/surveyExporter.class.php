<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: exportSurvey.class.php

class pSurveyExporter{

	private $_language, $_natLang, $_survey, $_fields = ['id', 'ipadress', 'language', 'total', 'RT_total', 'num_total', 'version'], $_dM, $_backgroundFields, $_wordFields, $_groupFields, $_groupWords = [], $_rows = [], $_sessions = [], $_versionNames = [], $_wordAnswers = [], $_backgroundAnswers = [], $_done = false; 

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
			return;

		if($this->_survey['user_id'] != pUser::read('id'))
			return;

		// Load ALL the things
		$this->getBackgroundFields();
		$this->getTaskFields();		
		$this->getGroupTotalFields();
		$this->getSessions();
		$this->getVersionNames();
		$this->fetchBackgroundAnswers();
		$this->fetchWordAnswers();

		foreach($this->_sessions as $session){
			// Create a temporary row

			$tempRow = ['id' => $session['id'], 'total' => 0, 'RT_total' => 0, 'num_total' => 0, 'ipadress' => $session['ipadress'], 'language' => $session['language'], 'version' => $this->_versionNames[$session['survey_version']]];
			
			if(isset($this->_backgroundAnswers['s_'.$session['id']]))
				foreach($this->_backgroundAnswers['s_'.$session['id']] as $bA)
					$tempRow[$this->_fields['bF_'.$bA['survey_question']]] = $bA['answer'];

			foreach($this->_groupFields as $gF){
				$tempRow[$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['RT_'.$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['num_'.$this->_fields['gF_'.$gF['id']]] = 0;
				$this->_groupWords[$this->_fields['gF_'.$gF['id']]] = [];
			}

			if(isset($this->_wordAnswers['s_'.$session['id']]))
				foreach($this->_wordAnswers['s_'.$session['id']] as $wA){
					$tempRow[$this->_fields['wF_'.$wA['word']]] = ($wA['isMatch'] == 1 ? '1' : ($wA['isMatch'] == 1 ? $wA['isMatch'] : $wA['answer']));
					$tempRow['total'] += $wA['isMatch'];
					$tempRow['num_total'] += $wA['isMatch'];
					$tempRow['RT_total'] += $wA['reactiontime'];
					$tempRow[$this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
					$tempRow['num_'.$this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
					$tempRow['RT_'.$this->_fields['gF_'.$wA['word_group']]] += $wA['reactiontime'];
					$this->_groupWords[$this->_fields['gF_'.$wA['word_group']]][] = 1;
				}

			$tempRow['total'] = $tempRow['total'] / count($this->_wordFields);
			$tempRow['RT_total'] = $tempRow['RT_total'] / count($this->_wordFields);
			
			foreach($this->_groupFields as $gF){
				$tempRow[$this->_fields['gF_'.$gF['id']]] = $tempRow[$this->_fields['gF_'.$gF['id']]] / count($this->_groupWords[$this->_fields['gF_'.$wA['word_group']]]);
				$tempRow['RT_'.$this->_fields['gF_'.$gF['id']]] = $tempRow['RT_'.$this->_fields['gF_'.$gF['id']]] / count($this->_groupWords[$this->_fields['gF_'.$wA['word_group']]]);
			}

			// Need to make sure the csv exporter is not going to stress about different words, maybe not existing other versions
			foreach($this->_fields as $field)
				if(!isset($tempRow[$field]))
					$tempRow[$field] = '';

			// Make the temp row less temp.
			$this->_rows[$session['id']] = $tempRow;

		}

		$this->_done = true;

	}

	private function fetchBackgroundAnswers(){
		if($fetch = $this->_dM->complexQuery("SELECT * FROM survey_background_answers AS ba JOIN survey_sessions ON ba.survey_session = survey_sessions.id AND survey_sessions.survey_id = '".$this->_survey['id']."';"))
			foreach($fetch->fetchAll() as $bA)
				$this->_backgroundAnswers['s_'.$bA['survey_session']][] = $bA;
	}

	private function fetchWordAnswers(){
		if($fetch = $this->_dM->complexQuery("SELECT * FROM survey_answers AS ba JOIN survey_sessions ON ba.survey_session = survey_sessions.id AND survey_sessions.survey_id = '".$this->_survey['id']."';"))
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
			$this->_fields['bF_' . $bF['id']] = $bF['internID'];
	}

	private function getTaskFields(){
		$this->_wordFields = $this->_dM->complexQuery("SELECT internID, id FROM survey_words WHERE survey_id = '".$this->_survey['id']."' AND ".$this->_natLang."")->fetchAll();
		foreach($this->_wordFields as $wF)
			$this->_fields['wF_' . $wF['id']] = $wF['internID'];
	}

	private function getGroupTotalFields(){
		$this->_groupFields = $this->_dM->complexQuery("SELECT internID, id FROM survey_word_groups WHERE survey_id = '".$this->_survey['id']."' AND ".$this->_natLang."")->fetchAll();
		foreach($this->_groupFields as $gF){
			$this->_fields['gF_' . $gF['id']] = $gF['internID'] . '_total';
			$this->_fields['RT_gF_' . $gF['id']] = 'RT_'.$gF['internID'] . '_total';
			$this->_fields['num_gF_' . $gF['id']] = 'num_'.$gF['internID'] . '_total';
		}

	}


	public function compile(){

		if(!$this->_done)
			return p::Out('Cannot create csv export...');

		$filename = p::FromRoot('/library/output/data-survey-'.md5(trim(preg_replace('/\W+/', '-', strtolower($this->_survey['survey_name']))).rand()).'.csv');
		
		$fp = fopen($filename, 'w');
		fwrite($fp, pack("CCC",0xef,0xbb,0xbf)); 
		fputcsv($fp, $this->_fields, ';');
		$makeFields = [];

		foreach ($this->_rows as $row){
			$makeFields = [];
			foreach($this->_fields as $field){
				if(is_float($row[$field]))
					$row[$field] = number_format($row[$field], 2);
				$makeFields[] = $row[$field];
			}

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

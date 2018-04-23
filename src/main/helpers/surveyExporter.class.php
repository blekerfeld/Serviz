<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: exportSurvey.class.php

class pSurveyExporter{

	private $_id, $_finalFile, $_language, $_natLang, $_survey, $_surveyLanguagesLocaleLookUp = [], $_calculations =  [], $_backgroundFillIn = [], $_fields = [], $_dM, $_backgroundFields, $_wordFields, $_groupFields, $_groupWords = [], $_rows = [], $_sessions = [], $_versionNames = [], $_wordAnswers = [], $_backgroundAnswers = [], $_done = false, $_modelAnswers, $_forceZeros = 1, $_includeStimuli = 1, $_factorDictionary; 

	public function __toString(){
		return; 
	}

	// Constructure accepts both a language code or a number
	public function __construct($id, $language = null, $natLang = 1, $forceZeros = 0){
		
		$this->_id = $id;
		$this->_language = ($language != null ? 'language = \'' . $language .'\' AND ' : '');
		$this->_natLang = $natLang;
		$this->_dM = (new pDataModel('surveys'));
		$this->_forceZeros = $forceZeros;

		// Let's check whether or not the survey exsists.
		if(!(($check = $this->_dM->complexQuery("SELECT * FROM surveys WHERE id = ".$id)) AND $check->rowCount() != 0 AND $this->_survey = $check->fetchAll()[0]))
			return;

		// Only own surveys can be exported
		if($this->_survey['user_id'] != pUser::read('id'))
			return;

		// Set the default fields
		$this->_fields = ['id', 'session_id', 'ipadress', 'language', 'version', 'overall', 'RT_overall', 'int_overall', 'audio_overall', 'audio_RT_overall', 'audio_int_overall', 'text_overall', 'text_RT_overall', 'text_int_overall'];


		return $this;

	}

	public function initialize(){
		$id = $this->_id;
		// Load ALL the things
		$this->initializeFields();
		$this->getSessions();
		$this->getVersionNames();
		$this->fetchBackgroundAnswers();
		$this->fetchWordAnswers();
	

		if(!$this->_modelAnswers = $this->_dM->complexQuery("SELECT * FROM survey_correct_translations WHERE survey_id = '".$id."'")->fetchAll())
			return;

		$modelAnswersTemp = [];

		foreach($this->_modelAnswers as $mA){
			if(!isset($modelAnswersTemp[$mA['internID']]))
				$modelAnswersTemp[$mA['internID']] = [];
			$modelAnswersTemp[$mA['internID']][] = $mA['translation'];
		}

		$this->_modelAnswers = $modelAnswersTemp;

		foreach($this->_dM->complexQuery("SELECT id, language_locale FROM survey_languages WHERE survey_id = '".$id."'")->fetchAll() AS $lang)
			$this->_surveyLanguagesLocaleLookUp[$lang['id']] = strtolower($lang['language_locale']);

		foreach($this->_dM->complexQuery("SELECT * FROM survey_calculations WHERE survey_id = '".$id."'")->fetchAll() as $calc){
			$this->_calculations[$calc['internID']] = $calc['formula'];
			$this->_fields[] = $calc['internID'];
		}

		return $this;

	}


	public function initializeFields(){
		$this->getBackgroundFields();
		$this->getTaskFields();	
		$this->getGroupTotalFields();		
		$this->buildFactorDictionary();
		// var_dump($this->_factorDictionary);
		// die();
		return $this;
	}

	// Chain: end point
	public function spewFields(){
		return $this->_fields;
	}

	public function toggleForcedZeros($force = null){
		if($this->_forceZeros == 0)	$this->_forceZeros = 1;
		if($this->_forceZeros == 1)	$this->_forceZeros = 0;
		return $this;
	}

	public function toggleStimuliVariables($force = null){
		if($this->_includeStimuli == 0)	$this->_includeStimuli = 1;
		if($this->_includeStimuli == 1) $this->_includeStimuli = 0;
		if($force != null) $this->_includeStimuli = $force;
		return $this;
	}

	public function overwriteFields($array){
		$this->_fields = $array;
		return $this;
	}

	private function buildFactorDictionary(){
		foreach($this->_dM->complexQuery("SELECT * FROM survey_factors WHERE survey_id = '".$this->_id."'")->fetchAll() as $factor){
			$this->_factorDictionary[$factor['internID']] = ['_based_on' => $factor['based_on']];
			$this->_fields[] = $factor['internID'];
			foreach($this->_dM->complexQuery("SELECT * FROM survey_levels WHERE factor_id = '".$factor['id']."'")->fetchAll() as $level){
				foreach($this->_dM->complexQuery("SELECT * FROM survey_answers_levels WHERE level_id = '".$level['id']."'")->fetchAll() as $answer){
					if(p::StartsWith($answer['answer'], 'range:')){
						$range = explode('-', p::Str($answer['answer'])->replacePrefix('range:', ''));
						foreach(range($range[0], $range[1]) as $number)
							$this->_factorDictionary[$factor['internID']][$number] = $level['value'];
					}
					else
						$this->_factorDictionary[$factor['internID']][$answer['answer']] = $level['value'];
				}
			}
		}
	}

	private function fetchBackgroundAnswers(){
		if($fetch = $this->_dM->complexQuery("SELECT * FROM survey_background_answers AS ba JOIN survey_sessions ON ba.survey_session = survey_sessions.id AND survey_sessions.survey_id = '".$this->_survey['id']."';"))
 			foreach($fetch->fetchAll() as $bA)
				$this->_backgroundAnswers['s_'.$bA['survey_session']][] = $bA;
	}

	private function fetchWordAnswers(){
		if($fetch = $this->_dM->complexQuery("SELECT *, sw.internID as internID, sw.id AS word_id FROM survey_answers AS ba JOIN survey_sessions ON ba.survey_session = survey_sessions.id AND survey_sessions.survey_id = '".$this->_survey['id']."' JOIN survey_words AS sw ON sw.id = ba.word;"))
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
		foreach($this->_backgroundFields as $bF){
			$this->_fields['bF_' . $bF['id']] = $bF['internID'];
			$this->_backgroundFillIn[$bF['internID']] = '&'.$bF['internID'];
		}
	}

	private function getTaskFields(){

		// Just for this task
		$this->_wordFields = $this->_dM->complexQuery("SELECT internID, id, word, audiofile, survey_word_group  FROM survey_words WHERE survey_id = '".$this->_survey['id']."' AND language = '".$this->_natLang."'")->fetchAll();

		$tempWordFields = [];

		foreach($this->_wordFields as $wF){
			$this->_fields['wF_' . $wF['id']] = $wF['internID'];
			$tempWordFields[$wF['id']] = $wF['id'];
			$this->_groupWords[$wF['survey_word_group']] = [];
			$this->_groupWords['audio_'.$wF['survey_word_group']] = [];
			$this->_groupWords['text_'.$wF['survey_word_group']] = [];
			if($wF['audiofile'] != ''){
				$this->_fields['wF_a_' . $wF['id']] = $wF['internID'].'_audio';
			}
			else{
				$this->_fields['wF_t_' . $wF['id']] = $wF['internID'].'_text';
			}
		}

		$this->_wordFields = $tempWordFields;
	}

	private function getGroupTotalFields(){
		$this->_groupFields = $this->_dM->complexQuery("SELECT internID, id FROM survey_word_groups WHERE survey_id = '".$this->_survey['id']."' AND language = '".$this->_natLang."'")->fetchAll();
		foreach($this->_groupFields as $gF){
			// Fields for the whole group
			$this->_fields['gF_' . $gF['id']] = $gF['internID'] . '_total';
			$this->_fields['int_gF_' . $gF['id']] = 'int_'.$gF['internID'];
			$this->_fields['RT_gF_' . $gF['id']] = 'RT_'.$gF['internID'];
			// Fields for the audio part of the group
			$this->_fields['gF_a_' . $gF['id']] = 'audio_' . $gF['internID'] . '_total';
			$this->_fields['int_a_gF_' . $gF['id']] = 'audio_' . 'int_'.$gF['internID'];
			$this->_fields['RT_a_gF_' . $gF['id']] = 'audio_' . 'RT_'.$gF['internID'];
			// Fields for the text part of the group
			$this->_fields['gF_t_' . $gF['id']] = 'text_' . $gF['internID'] . '_total';
			$this->_fields['int_t_gF_' . $gF['id']] = 'text_' . 'int_'.$gF['internID'];
			$this->_fields['RT_t_gF_' . $gF['id']] = 'text_' . 'RT_'.$gF['internID'];
		}

	}

	public function run(){
	
		$i = 0;

		foreach($this->_sessions as $session){
			// Create a temporary row
			$i++;
			$tempRow = ['id' => $i, 'session_id' => $session['id'], 'overall' => 0, 'RT_overall' => 0, 'int_overall' => 0, 'audio_overall' => 0, 'audio_RT_overall' => 0, 'audio_int_overall' => 0, 'text_overall' => 0, 'text_int_overall' => 0, 'text_RT_overall' => 0,'ipadress' => $session['ipadress'], 'language' => $this->_surveyLanguagesLocaleLookUp[$session['language']], 'version' => $this->_versionNames[$session['survey_version']]];
			
			if(isset($this->_backgroundAnswers['s_'.$session['id']]))
				foreach($this->_backgroundAnswers['s_'.$session['id']] as $bA)
					if(isset($this->_fields['bF_'.$bA['survey_question']]))
						$tempRow[$this->_fields['bF_'.$bA['survey_question']]] = $bA['answer'];

			// Time for the calculations
			foreach($this->_calculations as $key => $formula){

				foreach($this->_backgroundFillIn as $bID => $bVariable)
					if(isset($tempRow[$bID]))
						$formula = str_replace($bVariable, (int)$tempRow[$bID], $formula);
					else
						$formula = '0';

				$tempRow[$key] = p::Math($formula);
			}

			// Time for the factor grouping
			foreach($this->_factorDictionary as $key => $levels)
				if(@isset($levels[$tempRow[$levels['_based_on']]]))
					$tempRow[$key] = $levels[$tempRow[$levels['_based_on']]];


			foreach($this->_groupFields as $gF){
				$tempRow[$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['audio_'.$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['text_'.$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['RT_'.$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['audio_RT_'.$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['text_RT_'.$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['int_'.$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['audio_int_'.$this->_fields['gF_'.$gF['id']]] = 0;
				$tempRow['text_int_'.$this->_fields['gF_'.$gF['id']]] = 0;
			}



			if(isset($this->_wordAnswers['s_'.$session['id']]))
				foreach($this->_wordAnswers['s_'.$session['id']] as $wA){
					// Time for a final control!
					if($wA['isMatch'] == 0)
						$wA['isMatch'] = (in_array(trim(strtolower($wA['answer'])), $this->_modelAnswers[$wA['internID']]) ? 1 : 0);
					
					$tempRow[$this->_fields['wF_'.$wA['word_id']]] = ($wA['isMatch'] != 0 ? $wA['isMatch'] : ($wA['revised'] == 1 ? 0 : (trim($wA['answer']) == '' ? 0 : ($this->_forceZeros ? 0 :  $wA['answer']))));

					// This is an audio word
					if(isset($this->_fields['wF_a_'.$wA['word_id']])){
						$this->_groupWords['audio_'.$wA['word_group']][] = 1;
						$tempRow[$this->_fields['wF_a_'.$wA['word_id']]] = ($wA['isMatch'] != 0 ? $wA['isMatch'] : ($wA['revised'] == 1 ? 0 : (trim($wA['answer']) == '' ? 0 : ($this->_forceZeros ? 0 :  $wA['answer']))));

						// Audio grouping
						$tempRow['audio_' . $this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
						$tempRow['audio_int_' . $this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
						$tempRow['audio_RT_'.$this->_fields['gF_'.$wA['word_group']]] += $wA['reactiontime'];

						// Audio total
						$tempRow['audio_overall'] += $wA['isMatch'];
						$tempRow['audio_int_overall'] += $wA['isMatch'];
						$tempRow['audio_RT_overall'] += $wA['reactiontime'];
					}
					
					// This is a text word
					if(isset($this->_fields['wF_t_'.$wA['word_id']])){
						$this->_groupWords['text_'.$wA['word_group']][] = 1;
						$tempRow[$this->_fields['wF_t_'.$wA['word_id']]] = ($wA['isMatch'] != 0 ? $wA['isMatch'] : ($wA['revised'] == 1 ? 0 : (trim($wA['answer']) == '' ? 0 : ($this->_forceZeros ? 0 :  $wA['answer']))));
						// Text grouping
						$tempRow['text_' . $this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
						$tempRow['text_int_' . $this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
						$tempRow['text_RT_'.$this->_fields['gF_'.$wA['word_group']]] += $wA['reactiontime'];
						// Text total
						$tempRow['text_overall'] += $wA['isMatch'];
						$tempRow['text_int_overall'] += $wA['isMatch'];
						$tempRow['text_RT_overall'] += $wA['reactiontime'];
					}

					$tempRow['overall'] += $wA['isMatch'];
					$tempRow['int_overall'] += $wA['isMatch'];
					$tempRow['RT_overall'] += $wA['reactiontime'];
					$tempRow[$this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
					$tempRow['int_'.$this->_fields['gF_'.$wA['word_group']]] += $wA['isMatch'];
					$tempRow['RT_'.$this->_fields['gF_'.$wA['word_group']]] += $wA['reactiontime'];
					$this->_groupWords[$wA['word_group']][] = 1;
				}

			$tempRow['overall'] = $tempRow['overall'] / count($this->_wordFields);
			$tempRow['RT_overall'] = $tempRow['RT_overall'] / count($this->_wordFields);

			foreach($this->_groupFields as $gF){
	
				// Whole group
				$tempRow[$this->_fields['gF_'.$gF['id']]] = $tempRow[$this->_fields['gF_'.$gF['id']]]
				 / count($this->_groupWords[$wA['word_group']]);
				$tempRow['RT_'.$this->_fields['gF_'.$gF['id']]] = $tempRow['RT_'.$this->_fields['gF_'.$gF['id']]] / count($this->_groupWords[$wA['word_group']]);

				// Audio part
				$tempRow['audio_'.$this->_fields['gF_'.$gF['id']]] = $tempRow[$this->_fields['gF_'.$gF['id']]]
				 / count($this->_groupWords['audio_'.$wA['word_group']]);
				$tempRow['audio_RT_'.$this->_fields['gF_'.$gF['id']]] = $tempRow['RT_'.$this->_fields['gF_'.$gF['id']]] / count($this->_groupWords['audio_'.$wA['word_group']]);


				// Text part
				$tempRow['text_'.$this->_fields['gF_'.$gF['id']]] = $tempRow[$this->_fields['gF_'.$gF['id']]]
				 / count($this->_groupWords['text_'.$wA['word_group']]);
				$tempRow['text_RT_'.$this->_fields['gF_'.$gF['id']]] = $tempRow['RT_'.$this->_fields['gF_'.$gF['id']]] / count($this->_groupWords['text_'.$wA['word_group']]);

			}

			// Need to make sure the csv exporter is not going to stress about different words, maybe not existing other versions
			foreach($this->_fields as $field)
				if(!isset($tempRow[$field]))
					$tempRow[$field] = '';

			// Make the temp row less temp.
			$this->_rows[$session['id']] = $tempRow;

		}

		$this->_done = true;

		return $this;
	}


	public function export(){


		if(!$this->_done)
			return p::Out('Cannot create csv export...');

		$tempGoThroughFields = [];

		// No duplicate keys
		foreach($this->_fields as $key => $field)
			if(isset($tempGoThroughFields[$field]))
				unset($this->_fields[$key]);
			else
				$tempGoThroughFields[$field] = 1;
			
		// Remove stimuli fields if necessary
		if($this->_includeStimuli == 0){
			foreach($this->_wordFields as $key => $wF){
				if(isset($this->_fields['wF_'.$wF]))
					unset($this->_fields['wF_'.$wF]);
				if(isset($this->_fields['wF_a_'.$wF]))
					unset($this->_fields['wF_a_'.$wF]);
				if(isset($this->_fields['wF_t_'.$wF]))
					unset($this->_fields['wF_t_'.$wF]);
			}
		}
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
   		
   		$this->_finalFile = file_get_contents($filename);

		return $this;
	}

	public function spew(){
		echo $this->_finalFile;
		return $this;
	}

	public function quit(){
		// Nothing fancy, kthnxbai
		return die();	
	}



}

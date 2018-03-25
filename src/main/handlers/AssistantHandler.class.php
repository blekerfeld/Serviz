<?php
// Serviz 0.11-dev - Thomas de Roo - Licensed under MIT
// file: EntryObject.class.php

//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pAssistantHandler extends pHandler{

	public $_view, $_rulesheetModel;

	// Constructor needs to set up the view as well
	public function __construct(){
		// First we are calling the parent's constructor (pHandler)
		call_user_func_array('parent::__construct', func_get_args());
		// Override the datamodel
		$this->_dataModel = null;
		//View
		$this->_view = new pAssistantView($this, $this->_section);
	}


	public function render(){
		pTemplate::setNoBorder();
		$function = "render" . ucfirst($this->_section);
		if(method_exists($this, $function))
			return $this->$function();
	}

	public function renderDefault(){
		return $this->_view->render('default', $this->_prototype, false, false);
	}

	public function renderTranslate($ajax = false){
		$_SESSION['btChooser-translate'] = 0;
		return $this->_view->render($this->_section, [], $ajax);
	}

	public function renderRevise($ajax = false){
		return $this->_view->render($this->_section, [], $ajax);
	}


	public function renderBackground($ajax = false){
		return $this->_view->render($this->_section, [], $ajax);
	}

	public function getData($id = -1){

		if($this->_section == 'translate' AND isset(pRegister::session()['btChooser-translate'])){
			$this->_dataModel = new pDataModel('survey_words');
	
			$this->_data = $this->_dataModel->complexQuery("SELECT * FROM survey_words WHERE language != '".$_SESSION['btChooser-background']."' AND id NOT IN ( '" . @implode($_SESSION['btSkip-translate'], "', '") . "' ) LIMIT 1;")->fetchAll();
		}
		if($this->_section == 'background' AND isset(pRegister::session()['btChooser-background'])){
			$this->_dataModel = new pDataModel('survey_background_questions');
			$this->_data = $this->_dataModel->complexQuery("SELECT * FROM survey_background_questions WHERE doneStatus = ".(isset($_SESSION['btDone']) ? '1' : '0')." AND language = '".$_SESSION['btChooser-background']."' AND id NOT IN ( '" . @implode($_SESSION['btSkip-background'], "', '") . "' ) ORDER BY  sorter ASC LIMIT 1;")->fetchAll();
		}
		if($this->_section == 'revise' AND isset(pRegister::session()['btChooser-revise'])){
			$this->_dataModel = new pDataModel('survey_answers');
			$this->_data = $this->_dataModel->complexQuery("SELECT *, survey_words.word AS word_native FROM survey_answers JOIN survey_sessions ON survey_sessions.id = survey_answers.survey_session JOIN survey_words ON survey_words.id = survey_answers.word WHERE answer != '' AND revised = 0 AND survey_sessions.language = '".$_SESSION['btChooser-revise']."' LIMIT 1;")->fetchAll();
		}
		return false;
	}


	public function catchAction($action, $view, $arg = null){
		if($action == 'choose' AND isset(pRegister::arg()['ajax'], pRegister::post()['btChooser']))
			return $this->ajaxSetSession();
		elseif($action == 'serve' AND isset(pRegister::arg()['ajax']))
			return $this->serveCard();
		elseif($action == 'skip' AND isset(pRegister::arg()['ajax']))
			return $this->ajaxSkip();
		elseif($action == 'handle' AND isset(pRegister::arg()['ajax']))
			return $this->ajaxHandle();
		elseif($action == 'never' AND isset(pRegister::arg()['ajax']))
			return $this->ajaxNever();
		elseif($action == 'reset' AND isset(pRegister::arg()['ajax']))
			return $this->ajaxReset();
		else
			return parent::catchAction($action, $view, $arg);
	}


	public function serveCard(){
		$function = "serveCard" . ucfirst($this->_section);
		if(method_exists($this, $function))
			return $this->$function();
	}

	public function serveCardTranslate(){
		
		if(isset($this->_data[0]))
		 	return $this->_view->cardTranslate($this->_data[0], $this->_section);
		 else{
		 	$_SESSION['btDone'] = 1;
		 	echo "<script>loadBackground();</script>";
		 	return;
		 }
	}

	public function serveCardRevise(){
		if(isset($this->_data[0]))
		 	return $this->_view->cardRevise($this->_data[0], $this->_section);
	}

	public function serveCardBackground(){

		if(isset($this->_data[0]))
		 	return $this->_view->cardBackground($this->_data[0], $this->_section);
		 elseif(!isset($_SESSION['btDone'])){
		 	// We want to move to translate now! 
		 	$_SESSION['btChooser-translate'] = 0;
	 		echo "<script>loadTranslate();</script>";
		 }
		 else{
		 	(new pDataModel('survey_sessions'))->complexQuery("UPDATE survey_sessions SET doneStatus = 1 WHERE id = ".$_SESSION['btSurveyID']);
		 	$this->ajaxReset();
		 }

	}

	public function ajaxHandle(){
		$function = "ajaxHandle" . ucfirst($this->_section);
		if(method_exists($this, $function))
			return $this->$function();
	}

	public function ajaxReset(){
		unset($_SESSION['btChooser-translate']);
		unset($_SESSION['btChooser-background']);
		unset($_SESSION['btChooser-revise']);
		unset($_SESSION['btSkip-translate']);
		unset($_SESSION['btSkip-background']);
		unset($_SESSION['btDone']);
	}

	public function ajaxHandleTranslate(){

		$_SESSION['btSkip-translate'][] = $this->_data[0]['id'];
		$correctTranslations = [];
		$checkMatch = (new pDataModel('survey_correct_translations'))->setCondition(" WHERE survey_word = '".$this->_data[0]['id']."' AND language = '".pRegister::session()['btChooser-background']."' ")->getObjects();
		if($checkMatch->fetchAll())
			foreach($checkMatch->fetchAll() as $translation)
				$correctTranslations[] = trim(strtolower($translation['translation']));

		(new pDataModel('survey_answers'))->prepareForInsert([$_SESSION['btSurveyID'], $this->_data[0]['id'], $this->_data[0]['survey_word_group'],  pRegister::post()['translation'], ((in_array(trim(strtolower(pRegister::post()['translation'])), $correctTranslations)) ? '1' : '0')])->cleanCache('survey_questions_answers')->insert();
	}

	public function ajaxHandleBackground(){
		// Make this somehting else
		$_SESSION['btSkip-background'][] = $this->_data[0]['id'];

		(new pDataModel('survey_background_answers'))->prepareForInsert([$_SESSION['btSurveyID'], $this->_data[0]['id'], pRegister::post()['answer']])->cleanCache('survey_questions_answers')->insert();

	}


	public function ajaxSkip(){
		$_SESSION['btSkip-'.$this->_section][] = pRegister::post()['skip'];
	}

	public function ajaxNever(){
		$function = "ajaxNever" . ucfirst($this->_section);
		if(method_exists($this, $function))
			return $this->$function();
	}




	public function ajaxNeverTranslate(){
		$dM = new pDataModel('translation_exceptions');
		$dM->prepareForInsert(array(pRegister::post()['never'], $_SESSION['btChooser-translate'], pUser::read('id')));
		$dM->insert();
		$dM->cleanCache('words');
	}

	public function ajaxNeverBackground(){
		$dM = new pDataModel('translation_exceptions');
		$dM->prepareForInsert(array(pRegister::post()['never'], $_SESSION['btChooser-translate'], pUser::read('id')));
		$dM->insert();
		$dM->cleanCache('words');
	}


	public function getUserIP()
	{
	    if(filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
	       return @$_SERVER['HTTP_CLIENT_IP'];
	    elseif(filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
	       return @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    else
		   return $_SERVER['REMOTE_ADDR'];
	}


	public function ajaxSetSession(){
		if($this->_section == 'background'){
			// Let s create a session as well
			$_SESSION['btSurveyID'] = (new pDataModel('survey_sessions'))->prepareForInsert([$this->getUserIP(), 'Somewhere', pRegister::post()['btChooser'], 'NOW()', 0])->insert();
			$_SESSION['btChooser-translate'] = 0;
		}
		$_SESSION['btSkip-'.$this->_section] = array();
		return pRegister::session('btChooser-'.$this->_section, pRegister::post()['btChooser']);
	}

	
}
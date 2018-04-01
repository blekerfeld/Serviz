<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: EntryObject.class.php

//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pAssistantHandler extends pHandler{

	public $_view, $_rulesheetModel, $_doesNotExist = false, $_surveyID, $_survey = ['is_closed' => 1], $_surveyLanguages = [];

	// Constructor needs to set up the view as well
	public function __construct(){
		// First we are calling the parent's constructor (pHandler)
		call_user_func_array('parent::__construct', func_get_args());
		// Override the datamodel
		$this->_dataModel = null;
		$this->_view = new $this->_activeSection['view']($this, $this->_section);

		if(isset($this->_activeSection['check_survey']) AND $this->_activeSection['check_survey']){
			$this->_surveyID = p::HashId(pRegister::arg()['survey'], true)[0];
			if(!self::checkSurvey($this->_surveyID))
				$this->_doesNotExist = true;
		}
	}

	public function checkSurvey($id){
		// for now, only check whether survey exists
		$returnValue =  (($check = (new pDataModel)->complexQuery("SELECT * FROM surveys WHERE id = ".$id)) AND $check->rowCount() != 0 AND $this->_survey = $check->fetchAll()[0] AND $checkLang = (new pDataModel)->complexQuery("SELECT * FROM survey_languages WHERE survey_id = ".$id) AND $check->rowCount() != 0 AND $this->_surveyLanguages = $checkLang->fetchAll());
		
		if(!$returnValue)
			return false;
		
		$tempLang = [];
		foreach($this->_surveyLanguages as $lang)
			$tempLang[$lang['id']] = $lang;

		$this->_surveyLanguages = $tempLang;
		return true;
	}

	public static function _checkSurvey($id){
		// for now, only check whether survey exists
		return (($check = (new pDataModel)->complexQuery("SELECT * FROM surveys WHERE id = ".$id)) AND $check->rowCount() != 0);
	}


	public function render($ajax = false){

		$this->_view = new $this->_activeSection['view']($this, $this->_section);
		
		if($this->_doesNotExist)
			return p::Out("WHOOOPS!");
<<<<<<< HEAD
		if($this->_survey['is_closed'] == 1)
=======
		if(isset($this->_survey['survey_status']) AND $this->_survey['survey_status'] == 0)
>>>>>>> parent of 4798c5b... Merge remote-tracking branch 'origin/master'
			return $this->_view->renderClosed();

		return $this->_view->render($this->_section, [], $ajax);
	}


	public function activeLang(){
		return $this->_surveyLanguages[$_SESSION['btChooser-ask']];
	}

	public function getData($id = -1){
		return [];
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

	public function ajaxHandle(){
		$function = "ajaxHandle" . ucfirst($this->_section);
		if(method_exists($this, $function))
			return $this->$function();
	}

	public function ajaxReset(){
		unset($_SESSION['btChooser-do']);
		unset($_SESSION['btChooser-ask']);
		unset($_SESSION['btChooser-revise']);
		unset($_SESSION['btSkip-do']);
		unset($_SESSION['btSkip-ask']);
		unset($_SESSION['btDone']);
	}



	public function ajaxSkip(){
		$_SESSION['btSkip-'.$this->_section][] = pRegister::post()['skip'];
	}

	public function ajaxNever(){
		$function = "ajaxNever" . ucfirst($this->_section);
		if(method_exists($this, $function))
			return $this->$function();
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
		$_SESSION['btSkip-'.$this->_section] = array();
		return pRegister::session('btChooser-'.$this->_section, pRegister::post()['btChooser']);
	}

	
}
<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: admin.structure.class.php

class pAdminStructure extends pStructure{
	

	private function header(){

		$output = p::Markdown("## ".(new pIcon($this->_meta['icon']))." ".$this->_meta['title']);

		return $output;
	}

	public function render(){

		if(isset(pRegister::arg()['justTheLinks'], pRegister::arg()['ajax']))
			return $this->justTheLinks();

		if(!$surveys = (new pDataModel('surveys'))->setCondition(" WHERE user_id = '".pUser::read('id')."' ")->getObjects()->fetchAll())
			$surveys = null;

		if(!isset(pRegister::arg()['ajax']) AND pUser::noGuest())
			p::Out("<div class='btCard proper manageHolder'><div class='manage'><div class='side'>".pTemplate::userBox()."<br /><br /><a href='javascript:void(0);' onClick='window.location = \"".p::Url('?'.pParser::getApp().'/surveys')."\";' class='wSideButton ".(pParser::getSection() == 'surveys' ? 'active' : '')."'>".(new pIcon('clipboard-pulse-outline', 17))." ".SURVEY_MY."</a><br />".$this->mySurveysSelector($surveys)."<br />
				<div class='managenav'>".(isset(pRegister::arg()['activeSurvey']) ? $this->justTheLinks(pRegister::arg()['activeSurvey']) : '<div class="wPlaceHolder">'.SURVEY_SELECT_DESC.'</div>')."</div>
				</div><div class='main manageLoad'>");

		// The asynchronous j.a.x. gets to skip a bit 
		if(isset(pRegister::arg()['ajax']))
			goto ajaxSkipOutput;

		// Showing an error if there is one set.
		if($this->_error != null)
			p::Out("<div class='btCard minimal admin'>".$this->_error."</div>");

		// If there is an offset, we need to define that
		if(isset(pRegister::arg()['offset']))
			$this->_parser->setOffset(pRegister::arg()['offset']);

		ajaxSkipOutput:
		// Let's look for an action, that can not be an id! :D
		if(isset(pRegister::arg()['action'])){

			if(isset(pRegister::arg()['id']) AND !in_array(pRegister::arg()['action'], array('link-table')))
				$this->_parser->runData((is_numeric(pRegister::arg()['id']) ?  pRegister::arg()['id'] : p::HashId(pRegister::arg()['id'], true)[0]));

			$this->_parser->action(pRegister::arg()['action'], (boolean)isset(pRegister::arg()['ajax']), ((isset(pRegister::arg()['linked']) ? pRegister::arg()['linked'] : null)));
			if(isset(pRegister::arg()['ajax']))
				return true;
		}
		else{
			if(isset(pRegister::arg()['id']))
				$this->_parser->runData(is_numeric(pRegister::arg()['id']) ?  pRegister::arg()['id'] : p::HashId(pRegister::arg()['id'], true)[0]);
			else
				$this->_parser->runData();

			$this->_parser->render();
			if(isset(pRegister::arg()['ajax']))
				return true;
		}


		// Tooltipster time!
		p::Tooltipster();

		if(!isset(pRegister::arg()['ajax']) AND pUser::noGuest())
			p::Out("</div></div></div>");

	}

	public function mySurveysSelector($data){
		$output = "<select class='selectActiveSurvey' style='width:100%;display:inline-block;'>
		<option></option>";
		foreach($data as $opt)
			$output .= '<option value='.$opt['id'].' '.((isset(pRegister::arg()['activeSurvey']) AND pRegister::arg()['activeSurvey'] == $opt['id']) ? 'selected' : '').'>'.$opt['survey_name'].'</option>';
		$output .= "</select><script type='text/javascript'>
					$('.selectActiveSurvey').select2({ minimumResultsForSearch: -1,
					 placeholder: '".SURVEY_SELECT."', allowClear: true });
					$('.selectActiveSurvey').on('change', function(){
					  if($(this).val() != '' && $(this).val() != 0){
						$('.managenav').load('".p::Url('?manage/surveys/ajax/justTheLinks/activeSurvey/')."' + $(this).val());
					  	$('.manageLoad').load('".p::Url('?manage/overview/ajax/activeSurvey/')."' + $(this).val());
					  	window.history.pushState('string', '', '".p::Url('?manage/overview/activeSurvey/')."' + $(this).val());
					  }
					  else{
					  	$('.managenav').load('".p::Url('?manage/surveys/ajax/justTheLinks')."');
					  	$('.manageLoad').load('".p::Url('?manage/surveys/ajax')."');
					  	window.history.pushState('string', '', '".p::Url('?manage/surveys')."');
					  }
					});
				</script>";
		return $output;
	}

	public function justTheLinks($arg = ''){
		
		if(isset(pRegister::arg()['ajax']) AND !isset(pRegister::arg()['activeSurvey']))
			$arg = '';
		elseif(!isset(pRegister::arg()['ajax']))
			$arg = $arg;
		elseif(isset(pRegister::arg()['activeSurvey']))
			$arg = pRegister::arg()['activeSurvey']; 

		$output = '';

		if($arg == '')
			$output = "<div class='wPlaceHolder'>".SURVEY_SELECT_DESC."</div>";

		if($arg != '')
			foreach($this->_prototype as $key => $section){
				if($key == 'surveys') continue;
				if($key == 'permission') continue;
				$output .= "<a class='wSideButton ".((pRegister::arg()['section'] == $key OR ($key == 'overview' AND isset(pRegister::arg()['ajax']))) ? ' active ' : '')."' href='javascript:void(0)' onClick='window.location = \"".p::Url('?'.pRegister::app().'/'.$key.'/activeSurvey/'.$arg)."\";'>".(new pIcon($section['icon'], 12))." ".$section['surface']."</a>";
			}

		if(isset(pRegister::arg()['ajax']))
			echo $output;
		else
			return $output;
	}

}
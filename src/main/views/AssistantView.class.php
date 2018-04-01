<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: AsssistantView.class.php


class pAssistantView extends pView{

	public function renderChooser($data, $section = ''){

		p::Out("<div class='btCard proper bt chooser'><div class='btTitle'>".(new pIcon('fa-question-circle'))." ".BATCH_CHOOSE_ASSISTANT."</div>
			<div class='btSource'>		
			<div class='btChooser'>");

		$count = 0;
		unset($data['default']);
		foreach ($data as $key => $structure) {
			p::Out("<div class='option btOptionDefault' data-role='option' data-value='".$key."'>
				<span class='btStats normal'>".$structure['desc']."</span>
				<span style='display:inline-block;margin-top:14px;'><strong>".$structure['icon']." ".$structure['surface']."</strong></span><br id='cl' />

				</div>");
		}
		p::Out("</div></div>

			</div>");

		
	}

	public function render($section, $data, $ajax = false, $serveCard = true){

		p::Out('<div class="assistant assistantLoader">');

		// If app = survey, show logo
		if(pRegister::app() == 'survey' AND $this->_data->_survey['survey_logo'] != '')
			p::Out("<div class='btCard contains-logo no-padding'>
                      <img class='siteLogo' src='".p::Url($this->_data->_survey['survey_logo'])."' />
                    </div><br />");

		if($ajax == false)
			p::Out("<div class='dotsc hide'>".pTemplate::loadDots()."</div><div class='btLoad hide'></div><div class='btLoadSide hide'></div>");

		// If the session-chooser is already set we just load the first cards
		if(!isset($_SESSION['btChooser-'.$section])){
				$this->renderChooser($data, $section);
		}
			
	
		$hashKey = spl_object_hash($this);
		// Throwing this object's script into a session
		@pRegister::session($hashKey, $this->script($section));
		p::Out("<script type='text/javascript' src='".p::Url('pol://library/assets/js/key.js.php?key='.$hashKey)."'></script>");

		if(isset($_SESSION['btChooser-'.$section]) AND !isset(pRegister::arg()['noServe']))
			p::Out("<script type='text/javascript'>serveCard();</script>");

		if($ajax == false){
			$function = "renderBottom" . ucfirst($section);
			if(method_exists($this, $function))
				$this->$function();
		}
		

		p::Out('</div>');
	}

	public function renderClosed(){
		return p::Out("<div class='btCard bt proper'>
			<div class='btTitle'>".SURVEY_CLOSED_T."</div>
			".pTemplate::NoticeBox('fa-exclamation-triangle', SURVEY_CLOSED, 'warning-notice')."
		</div>");
	}

	public function wordAudioPlayer($file, $size){
		p::Out('<script>createjs.Sound.registerSound("'.p::Url('serviz://library/audio/' . $file).'", "stimulus");window.setTimeout(createjs.Sound.play("stimulus"), 1200);</script>');
		return "<a class='tooltip actionbutton player-".$size."' href='javascript:void();' onclick='createjs.Sound.play(\"stimulus\");'>".(new pIcon('volume-high', $size))."</a>";
	}

	public function script($section){
		
		$surveyPart = ((isset($this->_data->_activeSection['check_survey']) AND $this->_data->_activeSection['check_survey'] == true) ? '/'.p::HashId($this->_data->_surveyID).'/' : '/');

		return "
		$('.btOption').click(function(){
			$('.chooser').slideUp();
			$('.dotsc').slideDown();
			$('.btLoad').load('".p::Url('?'.pParser::$stApp.$surveyPart.$section.'/choose/ajax')."', {'btChooser': $(this).data('value')}, function(){
					serveCard(); 
			});

		});

		function loadTranslate(){
			window.location = '".p::Url('?'.pParser::$stApp.$surveyPart.'do')."';
		}

		function loadBackground(){
			window.location = '".p::Url('?'.pParser::$stApp.$surveyPart.'ask')."';
		}

		$('.btOptionDefault').click(function(){
			$('.chooser').slideUp();
			$('.dotsc').slideDown();
			$('.assistantLoader').load('".p::Url('?'.pParser::$stApp.'/'.
	(isset(pRegister::arg()['activeSurvey']) ? 'activeSurvey/'.pRegister::arg()['activeSurvey'] : ''))."' + $(this).data('value') + '/ajaxLoad', {}, function(e){
					window.history.pushState('string', '', '".p::Url('?'.pParser::$stApp.'/'.
	(isset(pRegister::arg()['activeSurvey']) ? '/activeSurvey/'.pRegister::arg()['activeSurvey'] : ''))."' + e.data('value'));
			});

		});

		function serveCard(){
			$('.btLoad').slideUp();
			$('.bottomCard').hide();
			$('.dotsc').slideDown();
			$('.btLoad').load('".p::Url('?'.pParser::$stApp.$surveyPart.$section.'/serve/ajax'.
	(isset(pRegister::arg()['activeSurvey']) ? '/activeSurvey/'.pRegister::arg()['activeSurvey'] : ''))."', {}, function(){
				$('.dotsc').slideUp();
				$('.btLoad').slideDown();
				$('.bottomCard').show();
				$('.btCardHelper').hide().attr('style', '').slideDown();
			});
		};

		function serveChoose(){
			$('.btLoad').slideUp();
			$('.bottomCard').hide();
			$('.dotsc').slideDown();
			$('.btLoad').load('".p::Url('?'.pParser::$stApp.$surveyPart.$section.'/ajax'.
	(isset(pRegister::arg()['activeSurvey']) ? '/activeSurvey/'.pRegister::arg()['activeSurvey'] : ''))."', {}, function(){
				$('.dotsc').slideUp();
				$('.btLoad').slideDown();
				$('.bottomCard').show();
				$('.btCardHelper').hide().attr('style', '').slideDown();
			});
		};

		function serveCardForce(sectionString){
			$('.btLoad').slideUp();
			$('.bottomCard').hide();
			$('.dotsc').slideDown();
			$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/')."' + sectionString + '/serve/ajax/', {}, function(){
				$('.dotsc').slideUp();
				$('.btLoad').slideDown();
				$('.bottomCard').show();
				$('.btCardHelper').hide().attr('style', '').slideDown();
			});
		};
		";
	}

}
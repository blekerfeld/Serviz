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

	public function wordAudioPlayer($file, $size){
		p::Out("<script type='text/javascript'>
				function playSound(){
					$.playSound('".p::Url('serviz://library/audio/'.$file)."');
				}
				setTimeout(function(){ playSound() }, 500);
				</script>");
		return "<a class='tooltip actionbutton player-".$size."' href='javascript:void();' onClick='playSound();'>".(new pIcon('volume-high', $size))."</a>";
	}

	
	
	public function script($section){
		return "
		
		$('.btOption').click(function(){
			$('.chooser').slideUp();
			$('.dotsc').slideDown();
			$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/choose/ajax')."', {'btChooser': $(this).data('value')}, function(){
					serveCard(); 
			});

		});

		function loadTranslate(){
			window.location = '".p::Url('?'.pParser::$stApp.'/do')."';
		}

		function loadBackground(){
			window.location = '".p::Url('?'.pParser::$stApp.'/ask')."';
		}

		$('.btOptionDefault').click(function(){
			$('.chooser').slideUp();
			$('.dotsc').slideDown();
			$('.assistantLoader').load('".p::Url('?'.pParser::$stApp.'/')."' + $(this).data('value') + '/ajaxLoad', {}, function(e){
					window.history.pushState('string', '', '".p::Url('?'.pParser::$stApp.'/')."' + e.data('value'));
			});

		});

		function serveCard(){
			$('.btLoad').slideUp();
			$('.bottomCard').hide();
			$('.dotsc').slideDown();
			$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/serve/ajax')."', {}, function(){
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
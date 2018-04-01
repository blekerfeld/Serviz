<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: AsssistantView.class.php


class pTranslationTaskView extends pAssistantView{

	
	public function renderBottomTranslate(){
		return;
	}

	
	public function cardTranslate($data, $section){
		
		$audioPlayer = '';

		if($data['audiofile'] != '')	
			if($data['word'] != '')
				$audioPlayer = $this->wordAudioPlayer($data['audiofile'], 35);
			else
				$audioPlayer = $this->wordAudioPlayer($data['audiofile'], 64);
		

		$surveyPart = ((isset($this->_data->_activeSection['check_survey']) AND $this->_data->_activeSection['check_survey'] == true) ? '/'.p::HashId($this->_data->_surveyID).'/' : '/');



		p::Out("
			<div class='btCard transCard proper bt'>
				<div class='btTitle'>
				".$this->_data->activeLang()['strTranslate']."</div>
				<div class='btSource'>
					<span class='btLanguage small'><span class='native'>
					<strong class='xxmedium pWord'>".$data['word']." ".$audioPlayer."</strong></span>
				</div>
				<div class='btTranslate'>
					<span class='btLanguage inline-title small'>".$this->_data->activeLang()['language_name']."</span><br />
					<input placeholder='' class='elastic nWord btInput translation' />
				</div><br />
				<div class='btButtonBar'>
					<a class='btAction button-handle blue no-float'>".$this->_data->activeLang()['strNext']."</a>
					<br id='cl' />
				</div>
		</div>
		
		<script type='text/javascript'>
			$(document).ready(function(){
				$('.ttip').tooltipster({animation: 'grow'});
				$('.translations').tagsInput({
							'defaultText': '".BATCH_TR_PLACEHOLDER."',
							'delimiter': '//',
						});
				$('.translations').elastic();

			});
			$('.button-skip').click(function(){
				$('.btLoadSide').load('".p::Url('?'.pParser::$stApp.$surveyPart.$section.'/skip/ajax')."', {'skip': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-handle').click(function(){
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.$surveyPart.$section.'/handle/ajax')."', {'translation': $('.translation').val()}, function(){
					serveCard();
				});
			});
		</script>
		");
	}

	

	public function cardTranslateEmpty($section){
		p::Out("<div class='btCard btCardEmpty transCard proper bt'>
				<div class='btTitle'>".BATCH_TRANSLATE."</div>
				<div class='center'><span class='inline-icon'>".(new pIcon('translate', 30))."</span>
				".pTemplate::NoticeBox('', sprintf(BATCH_TR_EMPTY, '<br />', '<a href="javascript:void(0);" class="button-back">', '</a>'),  'notice-subtle xmedium')."</div>
				<div class='btButtonBar'>
					
				</div>
		</div>
		<script type='text/javascript'>
		$('.button-back').click(function(){
				$('.btCardEmpty').hide();
				$('.bottomCard').hide();
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/reset/ajax')."', {'value': $('.translations').val()}, function(){
						serveChooser();
				});
			});
			
		</script>
		");
	}


}
<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: AsssistantView.class.php

class pRevisionView extends pAssistantView{

	public function renderChooser($data, $section = ''){
		$count = 0;


		$output = "<div class='btCard proper bt chooser admin'><div class='btTitle'>".BATCH_CHOOSE_LANGUAGE."</div>
			<div class='btSource'>	
			<div class='btChooser'>";

		foreach(pDataModel::getRecordsOrdered('survey_languages', 1, " choosable = 1 AND survey_id = '".pRegister::arg()['activeSurvey']."' ") as $value){
			$count++;
			$output .= "<div class='option btOption' data-role='option' data-value='".$value['id']."'>"."<strong>".$value['language_name']."</strong><br id='cl' />

				</div>";
		}

		p::Out($output."</div></div></div></div>");
		
	}

	
	
	public function cardRevise($data, $section){

		$audioPlayer = '';

		if($data['audiofile'] != '')	
			if($data['word_native'] != '')
				$audioPlayer = $this->wordAudioPlayer($data['audiofile'], 35);
			else
				$audioPlayer = $this->wordAudioPlayer($data['audiofile'], 64);
		

		p::Out("
			<div class='btCard transCard proper bt admin'>
				<div class='btTitle'>
				<a class='btFloat float-right button-back ttip' href='javascript:void();'>
						".(new pIcon('fa-level-up'))." ".BATCH_TR_GO_BACK."
					</a>
				Check non-matching answers</div>
				
				<div class='btSource center'>
					<span class='btLanguage small'><span class='native'>
					<strong class='xxmedium pWord'>".$data['word_native']." ".$audioPlayer."</strong></span>
				</div>

				<div class='btSource center'>
					<span class='btLanguage small'><span class='native'>
					<strong class='xxmedium pWord'>".$data['answer']."</strong></span>
				</div>

				<div class='btButtonBar center'>
					<a class='btAction button-right green medium no-float'>" . (new pIcon('thumb-up')) . " Right</a>
					<a class='btAction button-half blue medium no-float'>" . (new pIcon('thumbs-up-down')) . "</a>
					<a class='btAction button-wrong redbt medium no-float'>" . (new pIcon('thumb-down')) . " Wrong</a>
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
			
			$('.button-right').click(function(){
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/handle/ajax'.(isset(pRegister::arg()['activeSurvey']) ? '/activeSurvey/'.pRegister::arg()['activeSurvey'] : ''))."', {'value': 1}, function(){
					serveCard();
				});
			});

			$('.button-half').click(function(){
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/handle/ajax'.(isset(pRegister::arg()['activeSurvey']) ? '/activeSurvey/'.pRegister::arg()['activeSurvey'] : ''))."', {'value': '0.5'}, function(){
					serveCard();
				});
			});

			$('.button-wrong').click(function(){
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/handle/ajax'.(isset(pRegister::arg()['activeSurvey']) ? '/activeSurvey/'.pRegister::arg()['activeSurvey'] : ''))."', {'value': 0}, function(){
					serveCard();
				});
			});
			
		</script>
		");
	}

	
	public function cardReviseEmpty($section){
		p::Out("<div class='btCard btCardEmpty transCard proper bt admin'>
				<div class='center'><span class='inline-icon'>".(new pIcon('playlist-check', 70))."</span>
				".pTemplate::NoticeBox('', BATCH_REVISE_EMPTY,  'notice-subtle xmedium')."</div>
				<div class='btButtonBar center'>
					<a class='btAction button-restart blue medium no-float'>" . (new pIcon('restart')) . "</a>
				</div>
		</div>
		<script type='text/javascript'>
		$('.button-restart').click(function(){
			$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/reset/ajax'.(isset(pRegister::arg()['activeSurvey']) ? '/activeSurvey/'.pRegister::arg()['activeSurvey'] : ''))."', {}, function(){
				serveChoose();
			});
		});	
		</script>
		");
	}
	
}
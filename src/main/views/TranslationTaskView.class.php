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
		

		p::Out("
			<div class='btCard transCard proper bt'>
				<div class='btTitle'>
				<a class='btFloat float-right button-back ttip' href='javascript:void();'>
						".BATCH_RESTART." ".(new pIcon('fa-level-up-alt'))."
					</a>
				".BATCH_TRANSLATE."</div>
				<div class='btSource'>
					<span class='btLanguage small'><span class='native'>
					<strong class='xxmedium pWord'>".$data['word']." ".$audioPlayer."</strong></span>
				</div>
				<div class='btTranslate'>
					<span class='btLanguage inline-title small'>Translation</span><br />
					<input placeholder='' class='elastic nWord btInput translation' />
				</div><br />
				<div class='btButtonBar'>
					<a class='btAction button-handle blue medium no-float'>".BATCH_CONTINUE."</a>
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
				$('.btLoadSide').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/skip/ajax')."', {'skip': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-never').click(function(){
				$('.btLoadSide').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/never/ajax')."', {'never': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-handle').click(function(){
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/handle/ajax')."', {'translation': $('.translation').val()}, function(){
					serveCard();
				});
			});
			$('.button-back').click(function(){
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/reset/ajax')."', {}, function(){
					loadTranslate();
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
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.'/'.$section.'/reset/ajax')."', {'translations': $('.translations').val()}, function(){
					serveCard();
				});
			});
			
		</script>
		");
	}


}
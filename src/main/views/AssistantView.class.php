<?php
// Serviz 0.11-dev - Thomas de Roo - Licensed under MIT
// file: AsssistantView.class.php


class pAssistantView extends pView{

	public function renderChooserDefault($data, $section = ''){

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

	public function renderChooserRevise($data, $section = ''){
		$count = 0;
		$output = "<div class='btCard proper bt chooser'><div class='btTitle'>".BATCH_CHOOSE_LANGUAGE."</div>
			".pTemplate::NoticeBox('fa-info-circle fa-12', BATCH_TR_DESC_START,  'notice-subtle')."
			<div class='btSource'>			<div class='btButtonBar'>
			<div class='btChooser'>";

		foreach(pDataModel::getRecordsOrdered('survey_languages', 1, " choosable = 1 ") as $value){
			$count++;
			$output .= "<div class='option btOption' data-role='option' data-value='".$value['id']."'>"."<strong>".$value['language_name']."</strong><br id='cl' />

				</div>";
		}

		p::Out($output."</div></div></div></div>");
		
	}

	public function renderChooserBackground($data, $section = ''){
		$count = 0;
		$output = "<div class='btCard proper bt chooser'><div class='btTitle'>".BATCH_CHOOSE_LANGUAGE."</div>
			".pTemplate::NoticeBox('fa-info-circle fa-12', BATCH_TR_DESC_START,  'notice-subtle')."
			<div class='btSource'>			<div class='btButtonBar'>
			<div class='btChooser'>";

		foreach(pDataModel::getRecordsOrdered('survey_languages', 1, " choosable = 1 ") as $value){
			$count++;
			$output .= "<div class='option btOption' data-role='option' data-value='".$value['id']."'>"."<strong>".$value['language_name']."</strong><br id='cl' />

				</div>";
		}

		p::Out($output."</div></div></div></div>");
		
	}

	public function renderChooserTranslate($data, $section = ''){
		$count = 0;
		$output = "<div class='btCard proper bt chooser'><div class='btTitle'>".BATCH_CHOOSE_LANGUAGE."</div>
			".pTemplate::NoticeBox('fa-info-circle fa-12', BATCH_TR_DESC_START,  'notice-subtle')."
			<div class='btSource'>			<div class='btButtonBar'>
			<div class='btChooser'>";
		foreach(pLanguage::allActive() as $value){
			if($data[$value->read('id')]['percentage'] == 0)
				continue;
			$count++;
			$output .= "<div class='option btOption' data-role='option' data-value='".$value->read('id')."'>
				<span class='btStats'>".(new pIcon("playlist-check", 18))." "."<span class='per'>".round((100 - $data[$value->read('id')]['percentage']), 1)."%</span> <br />".BATCH_TR_PER_TRANS."</span><span class='btStats'>".(new pIcon("library-books", 17))." <span class='per'>".$data[$value->read('id')]['left']."</span> <br />".BATCH_TR_LEFT_TRANS."</span></span><br />".(new pDataField(null, null, null, 'flag'))->parse($value->read('flag'))." <strong>".$value->read('name')."</strong><br id='cl' />

				</div>";
		}
		p::Out($output."</div></div>

				
			</div>
			</div>");

		
	}

	public function render($section, $data, $ajax = false, $serveCard = true){


		p::Out('<div class="assistant assistantLoader">');

		if($ajax == false)
			p::Out("<div class='dotsc hide'>".pTemplate::loadDots()."</div><div class='btLoad hide'></div><div class='btLoadSide hide'></div>");

		// If the session-chooser is already set we just load the first cards
		if(!isset($_SESSION['btChooser-'.$section])){
			$function = "renderChooser" . ucfirst($section);
			if(method_exists($this, $function))
				$this->$function($data, $section);
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

	public function renderBottomTranslate(){
		return p::Out("<div class='btCard bt bottomCard'>".pTemplate::NoticeBox('fa-info-circle fa-12', BATCH_TR_DESC1 . " " . sprintf(BATCH_TR_DESC2, '<span class="imitate-tag">', '</span>', '<span class="imitate-tag">', '</span>'),  'notice-subtle')."</div>");
	}

	public function cardTranslate($data, $section){
		$audioPlayer = '';
		if($data['audiofile'] != ''){
			p::Out("<script type='text/javascript'>
				function playSound(){
					$.playSound('".p::Url('serviz://library/audio/'.$data['audiofile'])."');
				}
				setTimeout(function(){ playSound() }, 500);
				</script>");
			if($data['word'] != '')
				$audioPlayer = "<a class='tooltip actionbutton' href='javascript:void();' onClick='playSound();'>".(new pIcon('volume-high', 35))."</a>";
			else
				$audioPlayer = "<a class='tooltip actionbutton' href='javascript:void();' onClick='playSound();'>".(new pIcon('volume-high', 64))."</a>";
		}

		p::Out("
			<div class='btCard transCard proper bt'>
				<div class='btTitle'>
				<a class='btFloat float-right button-back ttip' href='javascript:void();'>
						".(new pIcon('fa-level-up'))." ".BATCH_TR_GO_BACK."
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
				$('.btLoadSide').load('".p::Url('?assistant/'.$section.'/skip/ajax')."', {'skip': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-never').click(function(){
				$('.btLoadSide').load('".p::Url('?assistant/'.$section.'/never/ajax')."', {'never': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-handle').click(function(){
				$('.btLoad').load('".p::Url('?assistant/'.$section.'/handle/ajax')."', {'translation': $('.translation').val()}, function(){
					serveCard();
				});
			});
			$('.button-back').click(function(){
				$('.btLoad').load('".p::Url('?assistant/'.$section.'/reset/ajax')."', {'translations': $('.translations').val()}, function(){
					serveCard();
				});
			});
			
		</script>
		");
	}

	public function cardRevise($data, $section){
		p::Out("
			<div class='btCard transCard proper bt'>
				<div class='btTitle'>
				<a class='btFloat float-right button-back ttip' href='javascript:void();'>
						".(new pIcon('fa-level-up'))." ".BATCH_TR_GO_BACK."
					</a>
				".BATCH_TRANSLATE."</div>
				<div class='btSource center'>
					<span class='btLanguage small'><span class='native'>
					<strong class='xxmedium pWord green-accent'>".$data['word_native']."</strong><br />
					<strong class='xmedium pWord'><em>".$data['answer']."</em> ? </strong></span>
				</div>
				<div class='btButtonBar center'>
					<a class='btAction button-handle green medium no-float'>Right</a>
					<a class='btAction button-handle redbt medium no-float'>Wrong</a>
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
				$('.btLoadSide').load('".p::Url('?assistant/'.$section.'/skip/ajax')."', {'skip': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-never').click(function(){
				$('.btLoadSide').load('".p::Url('?assistant/'.$section.'/never/ajax')."', {'never': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-handle').click(function(){
				$('.btLoad').load('".p::Url('?assistant/'.$section.'/handle/ajax')."', {'translation': $('.translation').val()}, function(){
					serveCard();
				});
			});
			$('.button-back').click(function(){
				$('.btLoad').load('".p::Url('?assistant/'.$section.'/reset/ajax')."', {'translations': $('.translations').val()}, function(){
					serveCard();
				});
			});
			
		</script>
		");
	}
	
	public function cardBackground($data, $section){
	
		if($data['is_slide'] == 0){
			p::Out("
				<div class='btCard transCard proper bt'>
					<div class='btTitle'>
					<a class='btFloat float-right button-back ttip' href='javascript:void();'>
							".(new pIcon('fa-level-up'))." ".BATCH_TR_GO_BACK."
						</a>
					<span class='btLanguage inline-title'><strong>".$data['question']."</strong></span></div>
					<div class='btTranslate'>
						
						");

			if($data['type'] == 'input')
				p::Out("<input placeholder='' class='elastic nWord btInput answer' />"); 
			else{
				p::Out("<span class='btNative'><select class='btInput answer full-width select-lexcat select2 xxmedium' style='width: 100%'>");
				foreach((new pDataModel('survey_background_dropdown_options'))->setCondition(" WHERE dropdown_id = '".$data['type']."'")->getObjects()->fetchAll() as $option)
					p::Out("<option value='".$option['dropdown_value']."'>".$option['dropdown_option']."</option>");
				p::Out("</select></span>");
			}
			p::Out("
					</div><br />
					<div class='btButtonBar'>
						<a class='btAction button-handle blue medium no-float'>".BATCH_CONTINUE."</a>
						<br id='cl' />
					</div>
			</div>");
		}
		else{
			p::Out("
				<div class='btCard transCard proper bt'>
					<span class='inline-icon'>".(new pIcon('information', 40))."</span>
					".p::MarkDown($data['slideText'])."

					".($data['force_noButtons'] == 0 ? "<div class='btButtonBar'>
						<a class='btAction button-skip blue medium no-float'>".BATCH_CONTINUE."</a>
						<br id='cl' />
					</div>" : "<div class='btButtonBar'>
						<a class='btAction button-skip-close green medium no-float'>".BATCH_DONE."</a>
						<br id='cl' />
					</div>")."
			</div>");
		}
		p::Out("
		
		<script type='text/javascript'>
			$(document).ready(function(){
				$('.ttip').tooltipster({animation: 'grow'});
				$('.select2').select2({});
			});
			$('.button-skip').click(function(){
				$('.btLoadSide').load('".p::Url('?assistant/'.$section.'/skip/ajax')."', {'skip': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-skip-close').click(function(){
				$('.btLoadSide').load('".p::Url('?assistant/'.$section.'/skip/ajax')."', {'skip': ".$data['id']."}, function(){
					serveCardForce('background');
				});
			});
			$('.button-never').click(function(){
				$('.btLoadSide').load('".p::Url('?assistant/'.$section.'/never/ajax')."', {'never': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-handle').click(function(){
				$('.btLoad').load('".p::Url('?assistant/'.$section.'/handle/ajax')."', {'answer': $('.answer').val()}, function(){
					serveCard();
				});
			});
			$('.button-back').click(function(){
				$('.btLoad').load('".p::Url('?assistant/'.$section.'/reset/ajax')."', {'translations': $('.translations').val()}, function(){
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
				$('.btLoad').load('".p::Url('?assistant/'.$section.'/reset/ajax')."', {'translations': $('.translations').val()}, function(){
					serveCard();
				});
			});
			
		</script>
		");
	}
	


	public function script($section){
		return "
		
		$('.btOption').click(function(){
			$('.chooser').slideUp();
			$('.dotsc').slideDown();
			$('.btLoad').load('".p::Url('?assistant/'.$section.'/choose/ajax')."', {'btChooser': $(this).data('value')}, function(){
				serveCard(); 
			});

		});

		function loadTranslate(){
			window.location = '".p::Url('?assistant/translate/')."';
		}

		function loadBackground(){
			window.location = '".p::Url('?assistant/background/')."';
		}

		$('.btOptionDefault').click(function(){
			$('.chooser').slideUp();
			$('.dotsc').slideDown();
			$('.assistantLoader').load('".p::Url('?assistant/')."' + $(this).data('value') + '/ajaxLoad', {}, function(){
				
			});

		});

		function serveCard(){
			$('.btLoad').slideUp();
			$('.bottomCard').hide();
			$('.dotsc').slideDown();
			$('.btLoad').load('".p::Url('?assistant/'.$section.'/serve/ajax')."', {}, function(){
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
			$('.btLoad').load('".p::Url('?assistant/')."' + sectionString + '/serve/ajax/', {}, function(){
				$('.dotsc').slideUp();
				$('.btLoad').slideDown();
				$('.bottomCard').show();
				$('.btCardHelper').hide().attr('style', '').slideDown();
			});
		};
		";
	}

}
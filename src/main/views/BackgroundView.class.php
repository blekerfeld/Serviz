<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: BackgroundView.class.php


class pBackgroundView extends pAssistantView{

	
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


}
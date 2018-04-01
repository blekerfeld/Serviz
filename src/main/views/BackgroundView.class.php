<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: BackgroundView.class.php


class pBackgroundView extends pAssistantView{

	
	public function renderChooser($data, $section = ''){

		$count = 0;
		$output = "<div class='btCard proper bt chooser'><div class='btTitle'>".BATCH_CHOOSE_LANGUAGE_Y."</div>
			
			<div class='btSource'>			
			<div class='btChooser'>";

		foreach(pDataModel::getRecordsOrdered('survey_languages', 1, " choosable = 1 ") as $value){
			$count++;
			$output .= "<div class='option btOption' data-role='option' data-value='".$value['id']."'>"."<strong>".$value['language_name']."</strong><br id='cl' />

				</div>";
		}

		p::Out($output."</div></div></div>");
		
	}

	
	public function giveFeedBack($data){
		$feedback = $this->_data->getFeedback();
		$data['slideText'] = str_replace('%ANSWERS%', $feedback['AnswerCount'], str_replace('%TOTAL%', $feedback['TotalCount'], str_replace('%CORRECT%', $feedback['TotalCorrect'], $data['slideText']))); 
		return p::Markdown($data['slideText']);		
	}

	public function cardBackground($data, $section){
	
		if($data['is_slide'] == 0){
			p::Out("
				<div class='btCard transCard proper bt'>
					<div class='btTitle'>
					<span class='btLanguage inline-title'><strong>".$data['question']."</strong></span></div>
					<div class='btTranslate'>
						
						");

			if($data['type'] == '_input')
				p::Out("<input placeholder='' class='elastic nWord btInput answer' />"); 
			elseif($data['type'] == '_textarea')
				p::Out("<textarea class='gtEditor ety-desc elastic allowtabs answer'></textarea>");
			elseif($data['type'] == '_tagsinput')
				p::Out("<textarea class='gtEditor tags ety-desc elastic allowtabs answer'></textarea>");
			elseif($data['type'] == '_age'){
				p::Out("<span class='btNative'><select class='btInput answer full-width select-lexcat select2 xxmedium' style='width: 100%'>");
				for ($i=10; $i < 100; $i++) { 
					p::Out("<option value='".$i."'>".$i."</option>");
				}
				p::Out("</select></span>");
			}
			elseif(p::StartsWith($data['type'], 'multi_')){
				p::Out("<span class='btNative'><select class='btInput answer full-width select-lexcat select2a xxmedium' multiple='multiple' style='width: 100%'>");
				foreach((new pDataModel('survey_background_dropdown_options'))->setCondition(" WHERE dropdown_id = '".$data['type']."'")->getObjects()->fetchAll() as $option)
					p::Out("<option value='".$option['dropdown_value']."'>".$option['dropdown_option']."</option>");
				p::Out("</select></span>");
			}
			else{
				$options = (new pDataModel('survey_background_dropdown_options'))->setCondition(" WHERE dropdown_id = '".$data['type']."'")->getObjects()->fetchAll();
				$preprocessedOptions = [];
				foreach($options as $opt)
					$preprocessedOptions[$opt['dropdown_option']] = $opt;

				if($data['order_swap'] == 1)
					$preprocessedOptions = array_reverse($preprocessedOptions);
				
				p::Out("<span class='btNative'><select class='btInput answer full-width select-lexcat select2 xxmedium' style='width: 100%'>");
				foreach($preprocessedOptions as $opt)
					p::Out("<option value='".$opt['dropdown_value']."'>".$opt['dropdown_option']."</option>");
				p::Out("</select></span>");
			}
			p::Out("
					</div>
					<div class='btButtonBar'>
						<a class='btAction button-handle blue medium no-float'>".$this->_data->activeLang()['strNext']."</a>
						<br id='cl' />
					</div>
			</div>");
		}
		else{
			p::Out("
				<div class='btCard transCard proper bt'>
					".$this->giveFeedBack($data)."
					".($data['force_noButtons'] == 0 ? "<div class='btButtonBar'>
						<a class='btAction button-skip blue medium no-float'>".$this->_data->activeLang()['strNext']."</a>
						<br id='cl' />
					</div>" : "<div class='btButtonBar'>
						<a class='btAction button-skip-close green medium no-float'>".$this->_data->activeLang()['strDone']."</a>
						<br id='cl' />
					</div>")."
			</div>");
		}

		$surveyPart = ((isset($this->_data->_activeSection['check_survey']) AND $this->_data->_activeSection['check_survey'] == true) ? '/'.p::HashId($this->_data->_surveyID).'/' : '/');

		p::Out("
		
		<script type='text/javascript'>
			$(document).ready(function(){
				$('.ttip').tooltipster({animation: 'grow'});
				$('.select2').select2({});
				$('.select2a').select2({placeholder: '".$this->_data->activeLang()['strChoose']."', allowClear: true});
				$('.tags').tagsInput({
					delimiter: ';'
				});
			});
			$('.button-skip').click(function(){
				$('.btLoadSide').load('".p::Url('?'.pParser::$stApp.$surveyPart.$section.'/skip/ajax')."', {'skip': ".$data['id']."}, function(){
					serveCard();
				});
			});
			$('.button-skip-close').click(function(){
				$('.btLoadSide').load('".p::Url('?'.pParser::$stApp.$surveyPart.$section.'/skip/ajax')."', {'skip': ".$data['id']."}, function(){
					serveCardForce('background');
				});
			});

			$('.button-handle').click(function(){
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.$surveyPart.$section.'/handle/ajax')."', {'answer': $('.answer').val()}, function(){
					serveCard();
				});
			});
			$('.button-back').click(function(){
				$('.btLoad').load('".p::Url('?'.pParser::$stApp.$surveyPart.$section.'/reset/ajax')."', {}, function(){
					loadBackground();
				});
			});
			
		</script>
		");
	}


}
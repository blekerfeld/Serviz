<?php
// Serviz 0.11-dev - Thomas de Roo - Licensed under MIT
// file: MenuView.class.php

// Accepts a RuleDataModel as $data parameter

class pRulesheetView extends pView{

	public function ruleTypeWatch($section){
		return "<script type='text/javascript'>

				function loadDesc(){
					$('.describeStatement').load('".p::Url('?grammar/'.$section.'/describe/ajax')."', {'rule' : $('#rule-content').val()});
					if($('#example').val() != ''){
						loadEx();	
					}
				}

				$(document).ready(function(){
					loadDesc();
				});

				var options = {
			    	callback: function (value) {
			    		loadDesc();
			    	},
			    	wait: 200,
			   		highlight: true,
			    	allowSubmit: false,
			    	captureLength: 1,
				};
				$('#rule-content').typeWatch( options );
				</script>";
	}

	public function exampleTypeWatch($section){
		return "<script type='text/javascript'>

				function loadEx(){
					$('.example').load('".p::Url('?grammar/'.$section.'/example/ajax')."', {'rule' : $('#rule-content').val(), 'lexform' : $('#example').val()});
				}

				var options = {
			    	callback: function (value) {
			    		loadEx();
			    	},
			    	wait: 200,
			   		highlight: true,
			    	allowSubmit: false,
			    	captureLength: 1,
				};
				$('#example').typeWatch( options );
				</script>";
	}

	public function rulesheetForm($section, $edit = false, $ruleset = ''){
		if($edit)
			$data = $this->_data->data()->fetchAll()[0];
			

		pTemplate::setBorder();

		p::Out("<div class='saving hide'>".pTemplate::loadDots()."</div>");

		// That is where the ajax magic happens:
		p::Out("<div class='ajaxSave rulesheet-margin'></div>");
		p::Out("<div class='rulesheet-margin'><span class='pSectionTitle extra'>".(new pIcon('fa-folder', 12))." <strong>".pSetView::breakDownName($ruleset['name'], 'grammar')." ".($edit ? ' → '.new pIcon('fa-file-o' , 12) . " " . $data['name']  : ' → '.RS_NEW_RULE)."</strong></span><div class='pSectionWrapper'>");
		p::Out("<div class='rulesheet no-padding'>
			<div class='left'>
			<div class='btCard rulesheetCard'>
				<div class='btTitle'>".RS_RULE_DETAILS."</div>
				".(!$edit ? pTemplate::NoticeBox('fa-info-circle fa-10', RS_RULE_WILL_BE_ADDED.' <strong class="medium">'.$ruleset['name']."</strong>.", 'notice-subtle') : '')."
				<div class='btSource'><span class='btLanguage'>".RS_NAME." <span class='xsmall darkred'>*</span></span></span><br />
				<span class='btNative'><input class='btInput nWord small normal-font name' value='".($edit ? $data['name'] : '')."'/></span></div>
				".($edit ? "<div class='btSource'><span class='btLanguage'>".RS_RULESET."<span class='xsmall darkred'>*</span></span></span><br />
							<span class='btNative'><select class='full-width select-ruleset select2a'>".(new pSelector('rulesets', $data['ruleset'], 'name', true, 'rules', true))->render()."</select></span></div>" : "")."
				<div class='btSource'><span class='btLanguage'>".RS_STATEMENT." </span><span class='xsmall darkred'>*</span></span><br />
				<span class='btNative'><textarea ".($section == 'inflection' ? "placeholder='prefix [stem] suffix'" : "placeholder='[context] < [find] > [context] = [replace]'")." spellcheck='false' class='btInput Rule elastic allowtabs' id='rule-content'>".($edit ? $data['rule'] : '')."</textarea><div class='describeStatement'></div></span>
					<div class='notice-subtle'>".(new pIcon('fa-info-circle', 10))." ".RS_SCOPE_DESC."</div>
				</div>
				".$this->ruleTypeWatch($section)."
				<br />
				<div class='btCard full proper'>
					<div class='btSource'><span class='btLanguage'><strong class='markdown-body'><h2 class='medium'>".RS_TEST."</h2></strong></span><br />
					<span class='btNative'><input class='btInput nWord small normal-font' id='example' placeholder='Lexical form'/><div class='example'></div></span></div>
					".$this->exampleTypeWatch($section)."
				</div>
				<div class='btButtonBar'>
						<a class='btAction green submit-form no-float'>".(new pIcon('fa-check-circle', 10))." ".SAVE."</a>
						");

		if($edit)
			p::Out((new pAction('remove', DA_DELETE, 'fa-times', 'btAction no-float redbt', null, null, $section, 'rulesheet', null, -3))->render($data['id']));

		p::Out("
						<br id='cl' />
						</div>
			</div>
		</div>
		<div class='right'>	");
		if(!in_array($section, array('context', 'ipageneration')))
			p::Out("
			<div class='btCard rulesheetCard'>
				<div class='btTitle'>".RS_SCOPE."</div>
					<div class='notice-subtle'>".(new pIcon('fa-info-circle', 10))." ".RS_SCOPE_DESC."</div><br />
					<div class='rulesheet inner'>
						<div class='left'>
							".p::Markdown("##### ".RS_PRIMARY_SELECTOR." ")."<br />
							<div class='btSource'><span class='btLanguage'>".DA_LEXCAT_DESC."</span><br />
							<span class='btNative'><select class='full-width select-lexcat select2' multiple='multiple'>".(new pSelector('types', $this->_data->_links['lexcat'], 'name', true, 'rules', true))->render()."</select></span></div>
							<div class='btSource'><span class='btLanguage'>".DA_GRAMCAT_TITLE."</span><br />
							<span class='btNative'><select class='full-width select-gramcat select2' multiple='multiple'>".(new pSelector('classifications', $this->_data->_links['gramcat'], 'name', true, 'rules', true))->render()."</select></span></div>
							<div class='btSource'><span class='btLanguage'>".DA_GRAMTAGS_TITLE."</span><br />
							<span class='btNative'><select class='full-width select-tags select2' multiple='multiple'>".(new pSelector('subclassifications', $this->_data->_links['tag'], 'name', true, 'rules', true))->render()."</select></span><br /><div class='notice-subtle'>".(new pIcon('fa-question-circle', 10))." ".RS_PRIMARY_SELECTORS_DESC."</div></div>
						</div>
						<div class='right'>
							".p::Markdown("##### Secondary selectors ")."<br />
							<div class='btSource'><span class='btLanguage'>Inflection tables</span><br />
							<span class='btNative'><select class='full-width select-tables select2' multiple='multiple'>".(new pSelector('modes', $this->_data->_links['modes'], 'name', true, 'rules', true))->render()."</select></span></div>
							<div class='btSource'><span class='btLanguage'>Table headings</span><br />
							<span class='btNative'><select class='full-width select-headings select2' multiple='multiple'>".(new pSelector('submodes', $this->_data->_links['submodes'], 'name', true, 'rules', true))->render()."</select></span></div>
							<div class='btSource'><span class='btLanguage'>Table rows</span><br />
							<span class='btNative'><select class='full-width select-rows select2' multiple='multiple'>".(new pSelector('numbers', $this->_data->_links['numbers'], 'name', true, 'rules', true))->render()."</select></span></div>
							<div class='btSource'><span class='btLanguage'>Table columns (<em>suborindate to rows</em>)</span><br />
							<span class='btNative'><select class='full-width select-columns select2' multiple='multiple'>".(new pSelector('columns', $this->_data->_links['columns'], 'name', true, 'rules', true))->render()."</select></span></div>
						</div>

				</div>");
		p::Out("</div>
		</div></div></div></div>
		<script type='text/javascript'>
		$('.submit-form').click(function(){
					$('.saving').slideDown();
					$('.ajaxSave').load('".p::Url("?grammar/".$section."/".($edit ? 'edit/'.$data['id'] : pRegister::arg()['action'])."/ajax")."', {
						".(!in_array($section, array('phonology', 'ipa')) ? "
						'lexcat': $('.select-lexcat').val(),
						'gramcat': $('.select-gramcat').val(),
						'tags': $('.select-tags').val(),
						'rows': $('.select-rows').val(),
						'headings': $('.select-headings').val(),
						'columns': $('.select-columns').val(),
						'tables': $('.select-tables').val()," : "")."
						'rule': $('#rule-content').val(),
						'name': $('.name').val(),
						".($edit ? "'ruleset': $('.select-ruleset').val()": '')."
					});
				});

			$('.select2').select2({placeholder: 'All possible', allowClear: true});
			$('.select2a').select2();
		</script>");
	}

	public function renderNew($ruleset){
		return $this->rulesheetForm($this->activeStructure['section_key'], false, $ruleset);
	}

	public function renderEdit($ruleset){
		return $this->rulesheetForm($this->activeStructure['section_key'], true, $ruleset);
	}

}
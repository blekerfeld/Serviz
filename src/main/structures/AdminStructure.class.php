<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: admin.structure.class.php

class pAdminStructure extends pStructure{
	
	public function prepareMenu(){
		// We don't accept double items
		foreach($this->_prototype as $item)
			if(isset($item['menu']) && pUser::checkPermission($this->itemPermission($item['section_key'])))
				$this->_menu[$item['menu']]['items'][] = $item;
	}

	private function checkActiveMain($name){
		if(isset($this->_menu[$name]['items']))
			foreach($this->_menu[$name]['items'] as $item)
				if(isset(pRegister::arg()['section']) && pRegister::arg()['section'] == $item['section_key'])
					return true;
	}

	private function checkActiveSub($name){

		if(isset(pRegister::arg()['section']) && pRegister::arg()['section'] == $name)
			return true;

	}

	public function renderMenu(){

		// To fix some things
		pTemplate::setTabbed();

		// Starting the menu
		$output = "<div class='card-tabs-bar wordsearch nomargin above'>
				<div class='stack'><a class='ssignore disabled no-select' href='javascript:void(0);'>".(new pIcon('tune', 14))." ".DA_TITLE."</a>";

		$items = 0;

		foreach($this->_menu as $key => $main){
			// Permission check
			if(pUser::checkPermission($this->itemPermission($main['section'])) OR isset($main['items'])){
				$output .= "<a href='".(isset($main['section']) ? p::Url("?".$this->_app."/".$main['section']) : '')."' class='".(($this->checkActiveMain($key) OR (isset(pRegister::arg()['section'], $main['section']) AND pRegister::arg()['section'] == $main['section'])) ? 'active' : '')." ttip' title='
					<strong>".htmlspecialchars($main['surface'])."</strong>";

				if(isset($main['items']))
					foreach($main['items'] as $item){
						$output .= "<a href=\"".p::Url("?".$this->_app."/".$item['section_key'])."\" class=\"ttip-sub ".($this->checkActiveSub($item['section_key']) ? 'active' : '')."\">".(new pIcon($item['icon'], 12))." ". htmlspecialchars($item['surface'])."</a>";
					}

				$items++;

				$output .= "'>".(new pIcon($main['icon'], 16))." ".$main['surface'].(isset($main['items']) ? " ".(new pIcon('fa-caret-down', 14)) : '')."</a>";
		}

		}

		$output .= "</div></div>";
		
		if($items == 0)
			return false;

		return p::Out($output);

	}

	private function header(){

		$output = p::Markdown("## ".(new pIcon($this->_meta['icon']))." ".$this->_meta['title']);

		return $output;
	}

	public function render(){

		// The asynchronous j.a.x. gets to skip a bit 
		if(isset(pRegister::arg()['ajax']))
			goto ajaxSkipOutput;

		// Preparing the menu
		$this->prepareMenu();

		$this->renderMenu();


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


		// Time for the menu
		


		// Tooltipster time!
		p::Tooltipster();

	}

}
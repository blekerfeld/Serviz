<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: admin.structure.class.php

class pAdminStructure extends pStructure{
	

	private function header(){

		$output = p::Markdown("## ".(new pIcon($this->_meta['icon']))." ".$this->_meta['title']);

		return $output;
	}

	public function render(){

		if(!isset(pRegister::arg()['ajax']))
			p::Out("<div class='btCard proper'>");

		// The asynchronous j.a.x. gets to skip a bit 
		if(isset(pRegister::arg()['ajax']))
			goto ajaxSkipOutput;


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

		if(!isset(pRegister::arg()['ajax']))
			p::Out("</div>");

	}

}
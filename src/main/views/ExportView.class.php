<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: AsssistantView.class.php

class pExportView extends pAssistantView{

	public function renderChooser($data, $section = ''){
		p::Out(new pAjaxLoader(p::Url('?csv/'.pRegister::arg()['activeSurvey'])));
	}

	
	
	public function cardExport($data, $section){

	}

	
	public function cardExportEmpty($section){
		
	}
	
}
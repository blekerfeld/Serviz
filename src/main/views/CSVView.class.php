<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: HomeView.class.php

class pCSVView extends pSimpleView{

	public function renderAll(){
		$export = new pSurveyExporter(pRegister::arg()['surveyID']);
		$export->compile();
		die();
	}



}
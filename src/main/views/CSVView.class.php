<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: CSVView.class.php

class pCSVView extends pSimpleView{

	public function renderAll(){
		(new pSurveyExporter(pRegister::arg()['surveyID']))
			->initialize()
			->run()
			->export()
			->spew()
			->quit();
	}

}
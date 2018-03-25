<?php
// Serviz 0.11-dev - Thomas de Roo - Licensed under MIT
// file: TerminalView.class.php



class pGenerateView extends pSimpleView{

	public function renderAll(){
		/// Just as simple as that :)

		$x = new pSurveyExporter(2);
		$x->compile();
		die();

	}

}
<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: ExampleView.class.php
//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pStatsView extends pView{

	public function render(){

		p::Out("<div class='home-margin'>");
		p::Out("<div class='statsView'><span class='statsNum'>".$this->_data->_sessionsInfo['totalCount']."</span><br />".SURVEY_SESSIONS_ALL."</div>");
		p::Out("<div class='statsView'><span class='statsNum'>".$this->_data->_sessionsInfo['doneCount']."</span><br />".SURVEY_SESSIONS_DONE."</div>");

		
		p::Out("<h2>".$this->_data->_survey['survey_name']."</h2>");

		p::Out("
				<div class='btButtonBar top'>
					<a class='btAction green no-float button-revise' href='javascript:void(0);'>".(new pIcon('calendar-multiple-check'))." ".SURVEY_REVISE."</a>

					<a class='btAction blue no-float button-export' href='javascript:void(0);' onClick='window.location=\"".p::Url('?csv/'.pRegister::arg()['activeSurvey'])."\"'>".(new pIcon('file-export'))." ".SURVEY_EXPORT."</a>
					<a class='btAction no-border no-float' target='_blank' href='".p::Url('?survey/'.p::HashId(pRegister::arg()['activeSurvey']))."'>".(new pIcon('open-in-new'))." ".SURVEY_LINK."</a>
				</div><br />
				<div class='assistant assistantLoader'>
				</div>
				<script type='text/javascript'>
				$('.button-revise').click(function(){
					$('.assistantLoader').load('".p::Url('?assistant/revise/activeSurvey/'.pRegister::arg()['activeSurvey'].'/ajax')."')
				});
				</script>
			");

		p::Out("</div>");
	}


}
<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: Entry.class.php

//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pTranslationView extends pEntryView{

	// This function shows the translations title and a little additional information
	public function title($flag = '', $backhref = null){

		//"<a class='' href='javascript:void();'' onclick='window.history.back();'' >".(new pIcon('fa-arrow-left', 12))."</a><strong class='pWord'><span class='native'><a>"

		
		$realTitle = p::Markdown("#<strong class='pWord'><span class='native'><a>".$this->_data['translation']."</a></span></strong>", true);

		$titleSection = new pEntrySection("", '', null, false, true);

		$titleSection->addInformationElement($flag." ".(new pLanguage($this->_data['language_id']))->parse());
		$titleSection->addInformationElement(DA_TRANSLATION);

		return $realTitle.$titleSection;

	}

	public function discussTitle(){
		p::Out("<span class='markdown-body'><h2>".sprintf(LEMMA_DISCUSS_TITLE, "<span class='native'><strong class='pWord'><a>".$this->_data['translation']."</a></strong></span>")."</h2></span>");
	}

	public function renderInfo(){
		if(pUser::noGuest() OR CONFIG_ALWAYS_SHOW_LAST_UPDATE == 1)
			return "<span class='small pDate'>«  ".sprintf(LEMMA_WORD_ADDED, "<a href='".p::Url('?auth/profile/'.$this->_data['user_id'])."'>".(new pUser($this->_data['user_id']))->read('username')."</a>", p::Date($this->_data['created_on']))." »</span><br />";
	}

	public function renderDesc($desc){
		return p::Out(new pEntrySection((new pIcon('fa-info', 12))." ".TRANSLATION_DESC, p::Markdown($desc, false)));
	}

	public function renderLemmas($lemmas){

		$content = "<ol>";
		$language = new pLanguage(0);
		
		$title = (new pDataField(null, null, null, 'flag'))->parse($language->read('flag')) . " " .  sprintf(TRANSLATION_LEMMAS, $language->parse());
		
		foreach($lemmas as $lemma)
			$content .= $lemma->parseListItem();
		
		$content .= "</ol>";

		return p::Out(new pEntrySection($title, $content));
	}

}
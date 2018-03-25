<?php
// Serviz 0.11-dev - Thomas de Roo - Licensed under MIT
// file: Entry.class.php

//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pLemmaView extends pEntryView{


	public function renderInfo(){
		if(pUser::noGuest() OR CONFIG_ALWAYS_SHOW_LAST_UPDATE == 1)
			return "<span class='small pDate'>«  ".sprintf(LEMMA_WORD_ADDED, "<a href='".p::Url('?auth/profile/'.$this->_data['created_by'])."'>".(new pUser($this->_data['created_by']))->read('username')."</a>", p::Date($this->_data['created']))." »</span><br />";
	}


	public function parseTranslations($translations, $justList = false){
		$overAllContent = "";
		// Going through the languages

		if(empty($translations))
			return false;

		foreach($translations as $key => $languageArray){
			$language = new pLanguage($key);
			if($key == 0)
				$title = (new pDataField(null, null, null, 'flag'))->parse($language->read('flag')) . " " .  sprintf(LEMMA_TRANSLATIONS_MEANINGS, $language->parse());
			else
				$title = (new pDataField(null, null, null, 'flag'))->parse($language->read('flag')) . " " . sprintf(LEMMA_TRANSLATIONS_INTO, $language->parse());
			$content = "<ol>";
			foreach($languageArray as $translation)
				$content .= $translation->parseListItemPreview().$translation->parseDescription();
			$content .= "</ol>";
			$overAllContent .= new pEntrySection($title, $content, '', true, true, true);
		}

		$showAll = '';

		if($justList)
				return $content;

		return new pEntrySection($showAll.(new pIcon('fa-inbox', 12))." ".LEMMA_TRANSLATIONS, $overAllContent);
	}


	public function parseExamples($examples){

		//return var_dump($examples);

		$overAllContent = "<ol>";
		// Going through the languages

		foreach($examples as $example)
			$overAllContent .= $example->parseListItem();

		return new pEntrySection((new pIcon('fa-quote-right', 12))." ".LEMMA_EXAMPLES, $overAllContent."</ol>");
	}

	public function parseInflections($inflector){
		return new pEntrySection((new pIcon('cards-variant', 12))." ".LEMMA_DECLENSION, $inflector->render()."<br id='cl' />", null, true, false, false, true);
	}


	// Requires the type, class and subclass
	public function title($type, $class, $subclass){


		//"<a class='' href='javascript:void();'' onclick='window.history.back();'' >".(new pIcon('fa-arrow-left', 12))."</a><strong class='pWord'><span class='native'><a>"

		// Sorry sorry sorry about the long code
		$realTitle = ' <a class="lemma-code float-right big print" href="#">'.(new pIcon('fa-share-alt',12)).'</a><a target="_blank" class="lemma-code float-right big print" href="'.p::Url('?entry/'.p::HashId($this->_data['id'])."/proper/print").'">'.(new pIcon('fa-print', 12)).'</a><a class="lemma-code big float-right ttip" href="'.p::Url('?entry/'.p::HashId($this->_data['id'])).'" title="'.$this->_data['id'].'">'.(new pIcon('fa-thumbtack', 12)).' '.p::HashId($this->_data['id']).'</a>'.p::Markdown("# <span class='native'><strong class='pWord'><a class='native'>".$this->_data['native']."</a></strong></span>".$this->renderIPA().($this->_data['hidden'] == 1 ? "<span class='pExtraInfo'>".(new pIcon('fa-eye-slash', 12))." ".LEMMA_HIDDEN."</span>" : '')." ", true);

		// Edit button


		$titleSection = new pEntrySection("", '', null, false, true);

		// Adding information elements to the title
		$titleSection->addInformationElement($type['name']);
		$titleSection->addInformationElement($class['name']);
		if($subclass != null)
			$titleSection->addInformationElement($subclass['name']);

		return $realTitle.$titleSection;

	}	

	public function discussTitle(){
		p::Out("<span class='markdown-body'><h2>".sprintf(LEMMA_DISCUSS_TITLE, "<span class='native'><strong class='pWord'><a>".$this->_data['native']."</a></strong></span>")."</h2></span>");
	}

	public function usageNotes($data, $icon){
		$parsed = '';
		// Parsing the notes
		foreach($data as $note){
			if($note['contents'] != '')
				$parsed .= p::Markdown($note['contents'], false);
		}

		// Returning the notes in an entry section
		if($parsed != '')
			return new pEntrySection(LEMMA_USAGE_NOTES, $parsed, $icon);

	}

	public function synonyms($data, $icon, $section = 'synonym'){
		$output = '';
		foreach($data as $synonym){

			if($synonym['word_id_1'] == $this->_data['id'])
				$synonym_id = $synonym['word_id_2'];
			else
				$synonym_id = $synonym['word_id_1'];

			$synonymLemma = new pLemma($synonym_id, 'words');

			$output .= '<a class="ttip '.$section.' score-'.$synonym['score'].'" title="Similarity: '.($section == 'antonym' ? 100 - $synonym['score'] : $synonym['score']).'%" href="'.p::Url('?entry/'.p::HashId($synonymLemma->_entry['id'])).'">'.$synonymLemma->native().'</a> ';
		}

		return new pEntrySection(($section == 'antonym' ? LEMMA_ANTONYMS : ($section == 'synonym' ? LEMMA_SYNONYMS : LEMMA_HOMOPHONES)), $output, $icon);
	}

	public function renderSearchResult($searchlang = 0, $noTransStatus = false, $noPreview){
		if(!($this->_data->_hitTranslation == null))
			$hitTranslation = '<em class="dHitTranslation">'.p::Highlight($this->_data->_query, $this->_data->_hitTranslation, '<strong class="dQueryHighlight">', '</strong>').'</em> '.(new pIcon('arrow-right').' ');
		else
			$hitTranslation = '';

		if($searchlang == 0 && $noPreview == false)
			$linkToWord = p::Highlight($this->_data->_query, $this->_data->renderPreviewLink(true), '<strong class="dQueryHighlight">','</strong>');
		elseif($noPreview == false)
			$linkToWord = $this->_data->renderPreviewLink(true);
		elseif($noPreview == true && $searchlang == 0)
			$linkToWord = "<a href='".$this->_data->renderSimpleHref(true)."'>".p::Highlight($this->_data->_query, $this->_data->_entry['native'], '<strong class="dQueryHighlight">','</strong>')."</a>";
		else
			$linkToWord = $this->_data->renderSimpleLink(true);


		p::Out('<div class="dWordWrapper">'.$hitTranslation.'<strong class="dWord"><span class="native">'.$linkToWord."</span>".$this->renderIPA('small')."</strong><span class='dType'> · ".$this->_data->generateInfoString()."</span> ".($this->_data->_entry['hidden'] == 1 ? "<span class='pExtraInfo'>".(new pIcon('fa-eye-slash', 12))." ".LEMMA_HIDDEN."</span>" : '')."
			".((count($this->_data->_translations) == 0 AND (pUser::checkPermission(-2)) AND $noTransStatus == false) ? "<span class='pExtraInfo'>".(new pIcon('fa-exclamation-triangle', 12))." ".LEMMA_NEED_TRANSLATIONS."</span>" : '')." <br />".$this->parseTranslations($this->_data->_translations, true)."</div>");
	}

	private function renderIPA($class = ''){
		if(isset($this->_data->_entry['ipa']))
			$ipa = $this->_data->_entry['ipa'];
		else
			$ipa = $this->_data['ipa'];

		return ($ipa != '' ? "<br /><span class='pIpa ".$class."' onClick='processIPA(\"".$ipa."\");'>/".$ipa."/ <span class='hide-partly'>".(new pIcon('fa-volume-up'))."</span></span>" : '');
	}

	public function parseListItem($entry){
		return "<li><span><span class='lemma lemma_".$entry['id']." tooltip'><strong class='dWordTranslation'><a href='".p::Url('?entry/'.$entry['id'])."' class='native'>".$entry['native']." </a></strong></span> ".(new pIcon('chevron-right', 13, 'opacity-6'))."<span class='dType'>
				".$this->_data->generateInfoString()."</span></span></li>";
	}

	public function antonyms($data, $icon){
		return $this->synonyms($data, $icon, 'antonym');
	}

	public function homophones($data, $icon){
		return $this->synonyms($data, $icon, 'homophone');
	}

	public function renderEtymology($data, $icon){
		$content = "";
		foreach($data as $ety)
			$content .= '<span class="markdown-body"><h5><em>'.sprintf(LEMMA_ETYMOLOGY_FA, "<a ".(is_numeric($ety['first_attestation']) ? "href=".p::Url('?entry/year/'.(int)$ety['first_attestation']) : "")." class='tooltip'>".$ety['first_attestation']."</a>").'</em></h5></span><span class="mmedium">'.p::Markdown($ety['desc']).'</span>';
		return new pEntrySection(LEMMA_ETYMOLOGY, $content, 'chart-timeline', true,  false, false, true, 'inherit');
	}

}
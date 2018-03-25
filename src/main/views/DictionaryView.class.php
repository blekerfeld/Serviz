<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: Entry.class.php

//$structure, $icon, $surface, $table, $itemsperpage, $dfs, $actions, $actionbar, $paginated, $section, $app = 'dictionary-admin')

class pDictionaryView extends pEntryView{

	public function renderEntry($lemma){
		return $lemma->renderSearchResult();
	}
	

}
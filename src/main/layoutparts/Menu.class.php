<?php
// Serviz 0.11-dev - Thomas de Roo - Licensed under MIT
// file: Menu.class.php

class pMenuView extends pLayoutPart{

	protected $_menu, $_meta, $_dispatch, $_permission, $_magicMenu;

	public function __construct(){
		$dispatch = pDispatcher::structure();
		$this->_permission = $dispatch['MAGIC_MENU']['default_permission'];
		$this->_meta = $dispatch['MAGIC_MENU']['items'];
		$this->_magicMenu = $dispatch['MAGIC_MENU'];
		unset($dispatch['MAGIC_MENU']);
		$this->_dispatch = $dispatch;
		$this->prepareMenu();
	}

	protected function itemPermission($key){
		if(isset($this->_meta[$key]['permission']))
			return $this->_meta[$key]['permission'];
		else
			return $this->_permission;
	}

	protected function checkSubItemPermission($items){
		$output = false;
		foreach ($items as $key => $item) {
			if(isset($item['permission']))
				if(pUser::checkPermission($item['permission']))
					$output = true;
				else
					$output = false;
			elseif(pUser::checkPermission($this->_permission))
				$output = true;
			else
				$output = false;
		}
		return $output;
	}

	public function render($pOut = false){

		// Starting the menu
		$output = "<div class='nav'>";

		$items = 0;

		foreach($this->_menu as $key => $main){
			if(isset($this->_meta[$key])){
				if(pUser::checkPermission($this->itemPermission($key)) OR (isset($this->_meta[$key]['subitems']) AND $this->checkSubItemPermission($this->_meta[$key]['subitems']))){
					$output .= "<a href='".(isset($this->_meta[$key]['app']) ? p::Url("?".$this->_meta[$key]['app']) : 'javascript:void(0);')."' class=' ".(isset($this->_meta[$key]['class']) ? $this->_meta[$key]['class'] : '')." ".($this->checkActiveMain($key) ? 'active' : '')." ttip_menu'";

					if(isset($this->_meta[$key]['subitems']) AND $this->checkSubItemPermission($this->_meta[$key]['subitems'])){
						$output .= " title='<div class=\"tooltipster-inner-menu\">";
						foreach($this->_meta[$key]['subitems'] as $item){
							if(pUser::checkPermission($this->itemPermission($key)))
								$output .= "<a href=\"".p::Url("?".$item['app'])."\" class=\"ttip-sub nav ".($this->checkActiveSub($item['app']) ? 'active' : '')."\">".(new pIcon($item['icon'], 12))." ". htmlspecialchars($item['name'])."</a>";
						}
						$output .= "</div>'";	
					}
					$items++;
					$output .= ">".(isset($this->_meta[$key]['icon']) ? (new pIcon($this->_meta[$key]['icon'], 12))."" : '').$this->_meta[$key]['name']."</a>";
				}
			}
		}

		// Any extra simple links?
		if(isset($this->_magicMenu['simple_links']))
			foreach($this->_magicMenu['simple_links'] as $link)
				$output .= "<a class='".$link['class ']." ".(($_SERVER['PHP_SELF'] == CONFIG_FOLDER . '/' . $link['file']) ? 'active' : '')."' href='".p::Url($link['file'])."'>".$link['name']."</a>";

		$output .= "</div><script type='text/javascript'>
			$('.ttip_menu').tooltipster({animation: 'grow', animationDuration: 100,  distance: 0, contentAsHTML: true, interactive: true, side:'bottom', trigger: 'click'});
		</script>";
		
		if($items == 0)
			return '<div class="nav"></div>';
		if($pOut)
			return p::Out($output);

		return $output;

	}


	public function __toString(){
		return $this->render();
	}

	protected function prepareMenu(){
		// We don't accept double items
		foreach(@$this->_dispatch as $key => $item)
			if(isset($item['menu']) && pUser::checkPermission($this->itemPermission($key)))
				$this->_menu[$item['menu']]['items'][$key] = $item;
	}

	protected function checkActiveMain($name){
		if(isset($this->_menu[$name]['items']))
			foreach($this->_menu[$name]['items'] as $key => $item)
				if(isset(pDispatcher::$active) && pDispatcher::active() == $key)
					return true;
	}

	protected function checkActiveSub($name){

		if(isset(pDispatcher::$active) && pDispatcher::active() == $name)
			return true;

	}

}
<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: structure.class.php
 

class pStructure{

	public $_name, $_meta, $_type, $_prototype, $_menu, $_menu_content, $_default_section, $_page_title, $_app, $_permission, $_dispatchStructure,  $_error;

	public static $permission;

	public function __construct($name, $type, $app, $default_section, $page_title, $dispatchStructure){
		$this->_name = $name;
		$this->_type = $type;
		$this->_app = $app;
		$this->_default_section = $default_section;
		$this->_page_title = $page_title;
		$this->_dispatchStructure = $dispatchStructure;
	}


	// This function returns a custom permission profile if it exists, other wise the default one
	public function itemPermission($item){
		if(isset($this->_prototype[$item]['permission']))
			return $this->_prototype[$item]['permission'];
		else
			return $this->_prototype['permission'];
	}

	public function compile(){

		// If the user requests a section and if it extist
		if(isset(pRegister::arg()['section']) AND array_key_exists(pRegister::arg()['section'], $this->_prototype))
			$this->_section = pRegister::arg()['section'];
		else{
			$this->_section = $this->_default_section;
		}


		$this->_parser = new pParser($this);

		$this->_parser->compile();

		pTemplate::setTitle($this->_page_title);
	}

	public function load(){
		try {
			// Loading the sturcture

			if($this->_type != '')
				if(file_exists(p::FromRoot("src/prototypes/".$this->_name.".".$this->_type.".prototype.php")))
					$this->_prototype = require_once p::FromRoot("src/prototypes/".$this->_name.".".$this->_type.".prototype.php");
				else
					$this->_prototype = $this->_dispatchStructure;
			else
				if(file_exists(p::FromRoot("src/prototypes/".$this->_name.".prototype.php")))
					$this->_prototype = require_once p::FromRoot("src/prototypes/".$this->_name.".prototype.php");
				else
					$this->_prototype = $this->_dispatchStructure;



			// Putting the			
			if(isset($this->_prototype['MAGIC_META']))
				$this->_meta = $this->_prototype['MAGIC_META'];
			else
				$this->_meta = $this->_prototype['metadata'];
			
			if(isset($this->_prototype['MAGIC_MENU']))
				$this->_menu = $this->_prototype['MAGIC_MENU'];
			
			unset($this->_prototype['MAGIC_META']);
			
			unset($this->_prototype['MAGIC_MENU']);


			if(isset($this->_meta['default_permission']))
				$this->_permission = $this->_meta['default_permission'];
			else
				$this->_permission = 0;

			$this->_prototype['permission'] = $this->_permission;

		} catch (Exception $e) {
			die();
		}
		
	}

	public function render(){

		// If there is an offset, we need to define that
		if(isset(pRegister::arg()['offset']))
			$this->_parser->setOffset(pRegister::arg()['offset']);
			
		// Let's handle the action by the object
		if(isset(pRegister::arg()['action'])){
			
			if(isset(pRegister::arg()['id']))
				$this->_parser->runData(pRegister::arg()['id']);
			$this->_parser->passOnAction(pRegister::arg()['action']);
		}
		else{
			if(isset(pRegister::arg()['id']))
				$this->_parser->runData(pRegister::arg()['id']);
			else
				$this->_parser->runData();
			$this->_parser->render();
		}


	}

}
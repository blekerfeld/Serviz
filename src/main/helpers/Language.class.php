<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: language.class.php

class pLanguage{

	public $id, $data, $dataModel; 
	public static $_languageCache = array();

	// This would work only with 'new pLanguage'
	public function __toString(){
		return $this->id;
	}

	// Constructure accepts both a language code or a number
	public function __construct($id){
		if(isset(self::$_languageCache[$id]))
			return $this->load(self::$_languageCache[$id]);
		$this->dataModel = new pDataModel('languages');
		if(is_numeric($id))
			$this->dataModel->getSingleObject($id);
		else{
			$this->dataModel->setCondition(" WHERE locale = '".$id."'");
			$this->dataModel->getObjects();
			if($this->dataModel->data()->rowCount() == 0 OR $this->dataModel->data()->rowCount() > 1)
				die("Could not fetch language");
		}
		$this->load($this->dataModel->data()->fetchAll()[0]);
		self::$_languageCache[$id] = $this->dataModel->data()->fetchAll()[0];
	}

	public static function allActive($notIs = 0){

		$data = (new pDataModel('languages'));
		$data->setCondition(" WHERE activated = 1 AND id <> ".$notIs);
		$array = array();
		foreach($data->getObjects()->fetchAll() as $lang){
			$array[] = new self($lang['id']);
		}
		return $array;
	}

	private function load($data){
		$this->id = $data['id'];
		$this->data = $data; 
	}

	public function parse(){
		return $this->data['name'];
	}

	// This will read out the given field
	public function read($key){
		if(array_key_exists($key, $this->data))
			return $this->data[$key];
		return false;
	}
	

}
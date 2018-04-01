<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: parser.class.php


class pParser{

	public $_section, $_app, $_data, $_paginated = true, $_condition, $_offset, $_handler, $structure, $_permission, $_parent;

	static public $stApp, $stSection;

	public function __construct($st){


		$this->structure = $st->_prototype;
		$this->_app = $st->_app;
		self::$stApp = $this->_app;
		self::$stSection = $st->_prototype[$st->_section]['section_key'];
		$this->_section = $st->_prototype[$st->_section]['section_key'];
		$this->_data =  $st->_prototype[$this->_section];
		$this->_parent = $st;

		// Loading the permission
		if(isset($this->structure[$this->_section]['permission']))
				$this->_permission = $this->structure[$this->_section]['permission'];
		else
			// The default permission
			$this->_permission = $this->structure['permission'];

		unset($this->structure['permission']);
	}

	// Used to switch off the pagination if needed

	public function togglePagination(){
		$this->_paginated = !$this->_paginated;
	}

	// Used to give the SELECT query of the dataModel a condition 

	// Passing on
	public function setCondition($condition){
		if($this->_handler != null)
			$this->_handler->setCondition($condition);
	}

	// Passing on
	public function setOrder($order){
		if($this->_handler != null)
			$this->_handler->setOrder($order);
	}

	public function compile(){

		// Toggle thingies
		if(isset($this->_data['order']) && $this->_data['order'] != false)
			$this->setCondition($this->_data['order']);
		if(isset($this->_data['condition']) && $this->_data['condition'] != false)
			$this->setCondition($this->_data['condition']);
		if($this->_data['disable_pagination'] != false)
			$this->togglePagination();

		// Creating the field set
		$this->_fields = new pSet; 
		if(isset($this->_data['datafields']))
			foreach($this->_data['datafields'] as $field)
				@$this->_fields->add($field);

		// Creating the actions per item set
		$this->_actions = new pSet;
		foreach($this->_data['actions_item'] as $action){
			$pAction = new pAction($action[0], $action[1], $action[2], $action[3], $action[4], $action[5], $this->_section, $this->_app);
			if(isset($action[6]))
				$pAction->setOverride($action[6]);
			$this->_actions->add($pAction);
		}

		// Creating the actions per item set
		$this->_actionbar = new pSet;
		foreach($this->_data['actions_bar'] as $action){
			if(is_array($action)){
				$pAction = new pAction($action[0], $action[1], $action[2], $action[3], $action[4], $action[5], $this->_section, $this->_app);
				if(isset($action[6]))
					$pAction->setOverride($action[6]);
			}
			else{
				$pAction = $action;
			}

			$this->_actionbar->add($pAction);
		}

			
		$this->_handler = new $this->_data['type']($this);
		
		$this->setCondition((isset($this->_data['condition']) ? $this->_data['condition'] : ''));
		
		$this->setOrder((isset($this->_data['order']) ? $this->_data['order'] : '1'));

		// Do we need to add links?
		if(isset($this->_data['outgoing_links']))
			foreach($this->_data['outgoing_links'] as $key => $link)
				$this->_handler->addLink($link, $key);


		
	}

	// A shortcut to running the queries of the adminObject which runs it inside its dataModel
	public function runData($id = -1){
		return $this->_handler->getData($id);
	}

	public function render(){

		// We can only render if we are allowed to 
		if(pUser::checkPermission($this->_permission))
			return $this->_handler->render();
		else{
			p::Out("<div class='btCard minimal admin'>".pTemplate::NoticeBox('fa-info-circle fa-12', DA_PERMISSION_ERROR, 'danger-notice')."</div>");
			return;
		}
	}

	// Passes on the action to the object
	public function passOnAction($action){
		if(pUser::checkPermission($this->_permission))
			return $this->_handler->catchAction($action, $this->_data['view']);
		else{
			return p::Out("<br />".pTemplate::NoticeBox('fa-info-circle fa-12', DA_PERMISSION_ERROR_ACTION, 'danger-notice'));
		}
	}

	// Allias function
	public function setOffset($offset){
		$this->_handler->setOffset($offset);
	}

	// This parsers actions
	public function action($name, $ajax, $linked){

		// Permission check again
		if(!pUser::checkPermission($this->_permission))
			return p::Out("<div class='btCard minimal admin'>".pTemplate::NoticeBox('fa-info-circle fa-12', DA_PERMISSION_ERROR, 'danger-notice')."</div>");

		// There are six magic actions that are coordinated by this function:
		// Those are: new, edit, remove, link-table, link-new, link-remove



		// Removing is like very simple! 
		elseif($name == 'remove' && $ajax){
			$action = $this->_handler->getAction($name);
			return $this->_handler->dataModel->remove($action->followUp, $action->followUpFields);
		}

		// If the action is like, not removing, then we need something else:


		// Our action!
		$action = $this->_handler->getAction($name);
		
		// Replacing the surface string of the action
		$this->_data['save_strings'][0] = $this->_data['surface'];

		$action = new pMagicActionForm($name, $this->_data['table'], $this->_fields, $this->_data['save_strings'], $this->_app, $this->_section, $this->_handler); 

		$action->compile();

		if($ajax)
			return $action->ajax();

		else
			return $action->form();
	}


	// This is used to be able to get to the active section and action from within other classes
	public static function getApp(){
		return self::$stApp;	
	}

	public static function getSection(){
		return self::$stSection;	
	}

}

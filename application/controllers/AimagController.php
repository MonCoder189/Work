<?php

class AimagController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		$aimags = new Model_DbTable_Aimag();
		$this -> view -> aimag = $aimags -> fetchAll($aimags -> select() -> order('name DESC'));
	}

	public function addAction() {
		$form = new Form_Aimag();
		$request = $this -> getRequest();
		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {

				$name = $this -> _request -> getParam('name');

				$news = new Model_DbTable_Aimag();
				$news -> insert(array('name' => $name, ));
				$this -> _redirect('aimag/index');
			}
		}

		$form -> setAction('add');
		$this -> view -> form = $form;
	}

	public function editAction() {
		$id = $this -> _request -> getParam('id');
		$form = new Form_Aimag();
		$request = $this -> getRequest();
		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {

				$name = $this -> _request -> getParam('name');

				$aimag = new Model_DbTable_Aimag();
				$aimag -> update(array('name' => $name), 'id = ' . $id);
				$this -> _redirect('aimag/index');
			}
		}

		$aimag = new Model_DbTable_Aimag();
		$res = $aimag -> fetchAll($aimag -> select() -> where('id = ' . $id));
		foreach ($res as $val) {
			$form -> name -> setValue($val["name"]);
		}
		$form -> add -> setLabel("Засварлах");
		$form -> setAction('../../edit/id/' . $id);
		$this -> view -> form = $form;
	}

	public function removeAction() {
		$id = $this -> _request -> getParam('id');
		$uid = Zend_Registry::get('uid');
		$aimag = new Model_DbTable_Aimag();
		if (Zend_Registry::get('role') == 'moderators' || Zend_Registry::get('role') == 'admins') {
			$aimag -> delete('id = ' . $id);
			$sum = new Model_DbTable_Sum();
			$sum -> delete('aimagid = ' . $id);
		}
		$this -> _redirect('aimag/index');
	}

}

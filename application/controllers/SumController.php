<?php

class SumController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $aimags = new Model_DbTable_Aimag();
        $this -> view -> aimag = $aimags -> fetchAll($aimags -> select() -> order('name DESC'));        
    }
    public function addAction()
    {
        $form = new Form_Sum();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                
                $sumname = $this -> _request -> getParam('name');
                $aimagname = $this -> _request -> getParam('aimag');

        		$aimags = new Model_DbTable_Aimag();
        		$aimag = $aimags -> fetchAll($aimags -> select() -> where('name = ?',$aimagname));
        		foreach ($aimag as $val) {
        			$aimagid = $val["id"];
        		}
                $news = new Model_DbTable_Sum();
                $news -> insert(array(
                        'aimagid' => $aimagid,
                        'name' => $sumname
                    ));
                $this -> _redirect('sum/index');
            }
        }

        $form -> setAction('add');
        $this -> view -> form = $form;        
    }
    public function deleteAction()
    {

    }
}


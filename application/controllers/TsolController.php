<?php

class TsolController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $tsols = new Model_DbTable_Tsol();
        $this -> view -> tsol = $tsols -> fetchAll($tsols -> select() -> order('score DESC'));
    }
    public function addAction()
    {
        $form = new Form_Tsol();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                
                $name = $this -> _request -> getParam('name');
                $score = $this -> _request -> getParam('score');

                $news = new Model_DbTable_Tsol();
                $news -> insert(array(
                        'name' => $name,
                        'score' => $score
                    ));
                $this -> _redirect('tsol/index');
            }
        }

        $form -> setAction('add');
        $this -> view -> form = $form; 
    }
    public function deleteAction()
    {
        $id = $this -> _request -> getParam('id');
        
    }
}


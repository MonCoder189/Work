<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function check($content)
    {
        $convert="";
        $tmp  = 0;
        $len = strlen($content); 
        for($i=0; $i < $len; $i++) {
            if($content[$i] == '<' and $content[$i+1] == 's' and $content[$i+2] == 'c' and $content[$i+3] == 'r' and $content[$i+4] == 'i' and $content[$i+5] == 'p' and $content[$i+6] == 't' and $content[$i+7] == '>') 
            {
                $i=$i+7; $tmp = 1;
            }
            else 
            {
                if($tmp == 0) $convert.=$content[$i];
                if($content[$i] == '<' and $content[$i+1]== '/' and $content[$i+2] == 's' and $content[$i+3] == 'c' and $content[$i+4] == 'r' and $content[$i+5] == 'i' and $content[$i+6] == 'p' and $content[$i+7] == 't' and $content[$i+8] == '>') 
                {
                    $tmp=0;
                    $i=$i+8;
                } 
            }
        }
        return $convert;
    }

    public function indexAction()
    {
        /*$form = new Form_Comment();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $content = $this -> _request -> getParam('commentbody');
                $content=$this->check($content);
                $uid = Zend_Registry::get('uid');
                $date = date("Y-m-d H:i:s");
                $uri =  'index/index/id/'.$id;   
                $comments = new Model_DbTable_Comment();
                $comments -> insert(array('uri' => $uri,
                        'content' => $content,
                        'uid' => $uid,
                        'date' => $date,
                    ));
                $this -> _redirect('news/more/id/'.$id);
            }
        }
        $form -> setAction('../../index/index');         
        $this -> view -> form = $form;*/

        $news = new Model_DbTable_News();
        $this -> view -> news = $news -> fetchAll($news -> select() -> order('date DESC'));

        /*
        $this -> view -> news1 = $news -> fetchAll($news -> select() -> where('isactive = 0') -> order('date DESC'));
        
        $page = 0;
        if ($this -> _request -> getParam("page") != null) $page = $this -> _request -> getParam("page");

        $this -> view -> page = $page;

        $q = $news -> fetchAll($news -> select() -> where('isactive = 1') -> order('isping DESC') -> order('date DESC')); 
        $id = $this -> _request -> getParam('id');
        $this -> view -> dugaar = $id;
        $paginator=Zend_Paginator::factory($q);
        $paginator->setItemCountPerPage("6")
                  ->setCurrentPageNumber($this->_getParam('page', 1));
        $this->view->medee=$paginator;

        $comments = new Model_DbTable_Comment();
        $this -> view -> comment = $comments -> fetchAll($comments -> select() -> order('date DESC'));
        */
    }

    public function addAction()
    {
        $form = new Form_News();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $title = $this -> _request -> getParam('title');
                $content = $this -> _request -> getParam('textcontent');
                //$isActive = $this -> _request -> getParam('isactive');
                $content = $this->check($content);
                echo 'end';
                $user_id = Zend_Registry::get('uid');
                $category = "news";
                $isping = 0;
                $date = date("Y-m-d H:i:s");
                    
                $convert="";
                $len = strlen($content); 
                for($i=0; $i < $len; $i++) {
                    if($content[$i] == "\"") 
                    {
                        $convert.="&quot;";
                    }
                    else 
                    {
                        $convert.=$content[$i];
                    }
                }
                $content = $convert;

                $news = new Model_DbTable_News();
                $news -> insert(array('user_id' => $user_id,
                        'title' => $title,
                        'content' => $content,
                        'date' => $date
                    ));
                $this -> _redirect('index/index');
            }
        }

        $form -> setAction('add');
        $this -> view -> form = $form;        
    }

    public function moreAction()
    {
        $id = $this -> _request -> getParam('id');
        $this -> view -> iid = $id;
        $news = new Model_DbTable_News();
        $this -> view -> news = $news -> fetchAll($news -> select() -> where('id = '.$id . ' AND isactive = 1'));
    } 
 }


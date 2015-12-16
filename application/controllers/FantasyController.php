<?php

class FantasyController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this -> _helper -> ajaxContext -> addActionContext('ajax', 'json') -> initContext();
        if ($this -> getRequest() -> isXmlHttpRequest()) {
            $this -> _helper -> layout -> disableLayout();
            $this -> _helper -> viewRenderer -> setNoRender(true);
        }
    }

    public function indexAction()
    {
        $id = Zend_Registry::get('uid');
        $gals = new Model_DbTable_Gal();
        $this -> view -> gal = $gals -> fetchAll($gals -> select() -> where('ezen_id ='. $id));  
    
        $bukhs = new Model_DbTable_Barildaan();
        $tmp = 1;
        $dp = 2;
        $q = $bukhs -> fetchAll($bukhs -> select() -> where('active ='.$tmp.' OR active ='.$dp));
        $paginator=Zend_Paginator::factory($q);
        $paginator->setItemCountPerPage(15)
                  ->setCurrentPageNumber($this->_getParam('page', 1));
        $this->view->medee=$paginator;
        $tmp = 0;
        $this->view->medee1 = $bukhs -> fetchAll($bukhs -> select() -> where('active ='.$tmp));


        $form = new Form_Comment();
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
        $this -> view -> form = $form; 


        $news = new Model_DbTable_News();
        $this -> view -> news = $news -> fetchAll($news -> select() -> where('isactive = 1') -> order('isping DESC') -> order('date DESC'));
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
  

    }
    public function myteamAction()
    {
    	$id = Zend_Registry::get('uid');
    	$this->view->userid = $id;
		$gals = new Model_DbTable_Gal();
		$this -> view -> gal = $gals -> fetchAll($gals -> select() -> where('ezen_id ='. $id)); 	
        $bukhs = new Model_DbTable_Bukh();
        $this -> view -> bukh = $bukhs -> fetchAll($bukhs -> select());  
        $barildaans = new Model_DbTable_Barildaan();
        $this -> view -> barildaan = $barildaans -> fetchAll($barildaans -> select());    
    } 
    public function teamaddAction()
    {
        $id = Zend_Registry::get('uid');
        $this->view->userid = $id;
        $gals = new Model_DbTable_Gal();
        $this -> view -> gal = $gals -> fetchAll($gals -> select() -> where('ezen_id ='. $id));     
        $bukhs = new Model_DbTable_Bukh();
        $this -> view -> bukh = $bukhs -> fetchAll($bukhs -> select());      
    }
    public function myteamchangeAction()
    {
        $id = Zend_Registry::get('uid');
        $this->view->userid = $id;
        $gals = new Model_DbTable_Gal();
        $this -> view -> gal = $gals -> fetchAll($gals -> select() -> where('ezen_id ='. $id));     
        $bukhs = new Model_DbTable_Bukh();
        $this -> view -> bukh = $bukhs -> fetchAll($bukhs -> select());      
    }     
    public function ajaxmyteamsortAction()
    {
        $id = Zend_Registry::get('uid');
        $result = $this -> _request -> getParam('id');
        
        $gals = new Model_DbTable_Gal();
        $gal = $gals -> fetchAll($gals -> select() -> where('ezen_id = '.$id));
        $rs1 = $result;
        
        foreach ($gal as $key => $val) 
        {
            $sp = $val['swap-bukh'];
            $sp1 = $sp;        
            if($sp == 1){ $sp = $val['bukh1_id']; break; }
            if($sp == 2){ $sp = $val['bukh2_id']; break; }
            if($sp == 3){ $sp = $val['bukh3_id']; break; }
            if($sp == 4){ $sp = $val['bukh4_id']; break; }
            if($sp == 5){ $sp = $val['bukh5_id']; break; }
            if($sp == 6){ $sp = $val['bukh6_id']; break; }
            if($sp == 7){ $sp = $val['bukh7_id']; break; }
            if($sp == 8){ $sp = $val['bukh8_id']; break; }
            if($sp == 9){ $sp = $val['bukh9_id']; break; }
            if($sp == 10){ $sp = $val['bukh10_id']; break; }
        }
        foreach ($gal as $key => $val) 
        {
            if($result == 1){ $result = $val['bukh1_id']; break; }
            if($result == 2){ $result = $val['bukh2_id']; break; }
            if($result == 3){ $result = $val['bukh3_id']; break; }
            if($result == 4){ $result = $val['bukh4_id']; break; }
            if($result == 5){ $result = $val['bukh5_id']; break; }
            if($result == 6){ $result = $val['bukh6_id']; break; }
            if($result == 7){ $result = $val['bukh7_id']; break; }
            if($result == 8){ $result = $val['bukh8_id']; break; }
            if($result == 9){ $result = $val['bukh9_id']; break; }
            if($result == 10){ $result = $val['bukh10_id']; break; }
        }
        $ret = array(); 
        $tmp = 0;
        
        //neg buh songoson baina

        if($sp1 == 0)
        {
            $tmp = 1;
            $gals -> update(array('swap-bukh' => $rs1), 'ezen_id = '.$id);
            $ret[] = array('tmp' => $tmp, 'bukh' => $rs1);
        }   

        //odoo 2 buh songogdson baina bairiin solino uu!!!
        
        else
        {
            $tmp = 2;
            //sp bolon result dugaartai buhchuudiin bairiig solino;
            $bukh1 = 'bukh'.$sp1.'_id';
            $bukh2 = 'bukh'.$rs1.'_id';
            
            $gals -> update(array($bukh1 => $result, $bukh2 => $sp), 'ezen_id = '.$id);
            $result = 0;
            $gals -> update(array('swap-bukh' => $result), 'ezen_id = '.$id);
            $ret[] = array('tmp' => $tmp, 'bukh' => $bukh1);
        }     
        echo Zend_Json :: encode($ret);
    }
    public function ajaxmyteambukhaddAction()
    {

        $result = $this -> _request -> getParam('text');
        $len = strlen($result);    
        $bukhs = new Model_DbTable_Bukh();
        $bukh = $bukhs -> fetchAll($bukhs -> select());
        $ret = array();
        foreach ($bukh as $key => $val) {
                        $str = $val['fname'];
                        $lent = strlen($str);
                        if($lent >= $len)
                        {
                            $tmp = 1;
                            for($i=0; $i<$len; $i++) {
                                if($str[$i] != $result[$i]){ $tmp = 0; break; }
                            }
                            if($tmp == 1) $ret[] = array('id' => $val['id'], 'uri' => $val['uri'], 'lname' => $val['lname'],'fname' => $val['fname']); 
                        }
        }
        echo Zend_Json :: encode($ret);
    }
    public function ajaxtablefantasymyteamAction() {
        $result = $this -> _request -> getParam('id');
        $ret = array();
        
        $bukhs = new Model_DbTable_Bukh();
        $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id = '.$result));
        foreach ($bukh as $key => $value) {
            $id = $value['id'];
            $lname = $value['lname'];
            $fname = $value['fname'];
            $tsol_id = $value['tsolid'];
        }
        $tsols = new Model_DbTable_Tsol();
        $tsol = $tsols -> fetchAll($tsols -> select() -> where('id = '.$tsol_id));
        $score = 0;
        foreach ($tsol as $key => $value) {
            $score = $value['score'];
        }
        $ret[] = array('id' => $id, 'lname' => $lname, 'fname' => $fname, 'score' => $score);
        echo Zend_Json :: encode($ret);
    }
    public function ajaxmyteamaddAction()
    {
        $uid = Zend_Registry::get('uid');
        $score = 0;

        $galname = $this -> _request -> getParam('text');
        $bukh1 = $this -> _request -> getParam('bukh1');
        $bukh2 = $this -> _request -> getParam('bukh2');
        $bukh3 = $this -> _request -> getParam('bukh3');
        $bukh4 = $this -> _request -> getParam('bukh4');
        $bukh5 = $this -> _request -> getParam('bukh5');
        $bukh6 = $this -> _request -> getParam('bukh6');
        $bukh7 = $this -> _request -> getParam('bukh7');
        $bukh8 = $this -> _request -> getParam('bukh8');
        $bukh9 = $this -> _request -> getParam('bukh9');
        $bukh10 = $this -> _request -> getParam('bukh10');
        
        $bukh1score = $this -> _request -> getParam('bukh1score');
        $bukh2score = $this -> _request -> getParam('bukh2score');
        $bukh3score = $this -> _request -> getParam('bukh3score');
        $bukh4score = $this -> _request -> getParam('bukh4score');
        $bukh5score = $this -> _request -> getParam('bukh5score');
        $bukh6score = $this -> _request -> getParam('bukh6score');
        $bukh7score = $this -> _request -> getParam('bukh7score');
        $bukh8score = $this -> _request -> getParam('bukh8score');
        $bukh9score = $this -> _request -> getParam('bukh9score');
        $bukh10score = $this -> _request -> getParam('bukh10score');

        $score += $bukh1score;
        $score += $bukh2score;
        $score += $bukh3score;
        $score += $bukh4score;
        $score += $bukh5score;
        $score += $bukh6score;
        $score += $bukh7score;
        $score += $bukh8score;
        $score += $bukh9score;
        $score += $bukh10score;

        $ret = array();
        $tmp = 0;
        if($bukh1 == null || $bukh2 == null || $bukh3 == null || $bukh4 == null || $bukh5 == null || 
            $bukh6 == null || 
            $bukh7 == null || $bukh8 == null && $bukh9 == null && $bukh10 == null || $galname == null)
        {
            $tmp = 1;
        }
        // Фантазигийн оноог шалгаж байна.
        if($tmp == 1 && $score > 120)
        {
            $ret[] = array('status' => 'no');
        }
        else
        {
            $ret[] = array('status' => 'yes');
            $gal = new Model_DbTable_Gal();
            $gal -> insert(array('name' => $galname, 'bukh1_id' => $bukh1, 'bukh2_id' => $bukh2, 
                'bukh3_id' => $bukh3, 'bukh4_id' => $bukh4, 'bukh5_id' => $bukh5, 'bukh6_id' => $bukh6, 
                'bukh7_id' => $bukh7, 
                'bukh8_id' => $bukh8, 'bukh9_id' => $bukh9, 'bukh10_id' => $bukh10, 'ezen_id' => $uid));
        }
        echo Zend_Json :: encode($ret);
    }
    public function naimaaaddbukhAction()
    {
        $result = $this -> _request -> getParam('id');
        $ret = array();
        
        $bukhs = new Model_DbTable_Bukh();
        $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id = '.$result));
        foreach ($bukh as $key => $value) {
            $id = $value['id'];
            $lname = $value['lname'];
            $fname = $value['fname'];
            $tsol_id = $value['tsolid'];
            $uri = $value['uri'];
        }
        $tsols = new Model_DbTable_Tsol();
        $tsol = $tsols -> fetchAll($tsols -> select() -> where('id = '.$tsol_id));
        $score = 0;
        foreach ($tsol as $key => $value) {
            $score = $value['score'];
        }
        $ret[] = array('id' => $id, 'lname' => $lname, 'fname' => $fname, 'score' => $score, 'uri' => $uri);
        echo Zend_Json :: encode($ret);
    }
    public function ajaxnaimaabukhavahAction()
    {
            $uid = Zend_Registry::get('uid');
            $id = $this -> _request -> getParam('id');
            
            $gt = new Model_DbTable_Gal;
            $gal = $gt -> fetchAll($gt -> select() -> where('ezen_id = '.$uid));

            foreach ($gal as $key => $value) {
                    $bukh1_id = $value['bukh1_id'];
                    $bukh2_id = $value['bukh2_id'];
                    $bukh3_id = $value['bukh3_id'];
                    $bukh4_id = $value['bukh4_id'];
                    $bukh5_id = $value['bukh5_id'];
                    $bukh6_id = $value['bukh6_id'];
                    $bukh7_id = $value['bukh7_id'];
                    $bukh8_id = $value['bukh8_id'];
                    $bukh9_id = $value['bukh9_id'];
                    $bukh10_id = $value['bukh10_id'];
            }
            $gals = array();
            $r = 1;
            $gals[$r++] = $bukh1_id;
            $gals[$r++] = $bukh2_id;
            $gals[$r++] = $bukh3_id;
            $gals[$r++] = $bukh4_id;
            $gals[$r++] = $bukh5_id;
            $gals[$r++] = $bukh6_id;
            $gals[$r++] = $bukh7_id;
            $gals[$r++] = $bukh8_id;
            $gals[$r++] = $bukh9_id;
            $gals[$r++] = $bukh10_id;
            $ind = 0;
            for($i = 1; $i <= 10; $i++)
            {
                if($gals[$i] == 0){ $ind = $i; break; }
            }
            $gals[$ind] = $id;
            $gt -> update(array('bukh1_id' => $gals[1],'bukh2_id' => $gals[2], 'bukh3_id' => $gals[3], 
            'bukh4_id' => $gals[4], 'bukh5_id' => $gals[5], 'bukh6_id' => $gals[6],'bukh7_id' => $gals[7], 
            'bukh8_id' => $gals[8], 'bukh9_id' => $gals[9], 'bukh10_id' => $gals[10]), 'ezen_id = '.$uid);
            $ret = array();
            echo Zend_Json :: encode($ret);        
    }
    public function naimaaAction()
    {
        $uid = Zend_Registry::get('uid');
        $tsols = new Model_DbTable_Tsol();
        $this -> view -> tsol = $tsols -> fetchAll($tsols -> select());
        $bukhs = new Model_DbTable_Bukh();
        $this -> view -> bukh = $bukhs -> fetchAll($bukhs -> select());
        $gals = new Model_DbTable_Gal;
        $this -> view -> gal = $gals -> fetchAll($gals -> select() -> where('ezen_id ='.$uid));
    }
    public function ajaxnaimaadeletebukhAction()
    {
        $uid = Zend_Registry::get('uid');
        $id = $this -> _request -> getParam('id');
        
        $bukh = 'bukh'.$id.'_id';   
        
        $gals = new Model_DbTable_Gal;
        $gal = $gals -> fetchAll($gals -> select() -> where('ezen_id = '.$uid));

        $bukh_id = 0;
        foreach ($gal as $key => $value) {
            if($id == 1)
            {
                $bukh_id = $value['bukh1_id'];
            }
            if($id == 2)
            {
                $bukh_id = $value['bukh2_id'];
            }
                        if($id == 3)
            {
                $bukh_id = $value['bukh3_id'];
            }
                        if($id == 4)
            {
                $bukh_id = $value['bukh4_id'];
            }
                        if($id == 5)
            {
                $bukh_id = $value['bukh5_id'];
            }
                        if($id == 6)
            {
                $bukh_id = $value['bukh6_id'];
            }
                        if($id == 7)
            {
                $bukh_id = $value['bukh7_id'];
            }
                        if($id == 8)
            {
                $bukh_id = $value['bukh8_id'];
            }
                        if($id == 9)
            {
                $bukh_id = $value['bukh9_id'];
            }
                        if($id == 10)
            {
                $bukh_id = $value['bukh10_id'];
            }
        }

        $bukhs = new Model_DbTable_Bukh;
        $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id = '.$bukh_id));
        $lname = "";
        $fname = "";
        $uri = "";
        $tsolid = 0;
        foreach ($bukh as $key => $value) {
            $lname = $value['lname'];
            $fname = $value['fname'];
            $uri = $value['uri'];
            $tsolid = $value['tsolid'];
        }
        $tsols = new Model_DbTable_Tsol;
        $tsol = $tsols -> fetchAll($tsols -> select() -> where('id = '.$tsolid));
        $score = 0;
        foreach ($tsol as $key => $value) {
            $score = $value['score'];
        }
        $ret = array();
        $ret[] = array('id' => $bukh_id, 'lname' => $lname, 'fname' => $fname,
         'uri' => $uri, 'score' => $score,'bukh_id' => $id);
        echo Zend_Json :: encode($ret);
    }
    public function ajaxnaimaabukhzarahAction()
    {
            $uid = Zend_Registry::get('uid');
            $id = $this -> _request -> getParam('id');
            
            $gt = new Model_DbTable_Gal;
            $gal = $gt -> fetchAll($gt -> select() -> where('ezen_id = '.$uid));

            foreach ($gal as $key => $value) {
                    $bukh1_id = $value['bukh1_id'];
                    $bukh2_id = $value['bukh2_id'];
                    $bukh3_id = $value['bukh3_id'];
                    $bukh4_id = $value['bukh4_id'];
                    $bukh5_id = $value['bukh5_id'];
                    $bukh6_id = $value['bukh6_id'];
                    $bukh7_id = $value['bukh7_id'];
                    $bukh8_id = $value['bukh8_id'];
                    $bukh9_id = $value['bukh9_id'];
                    $bukh10_id = $value['bukh10_id'];
            }
            $gals = array();
            $r = 1;
            $gals[$r++] = $bukh1_id;
            $gals[$r++] = $bukh2_id;
            $gals[$r++] = $bukh3_id;
            $gals[$r++] = $bukh4_id;
            $gals[$r++] = $bukh5_id;
            $gals[$r++] = $bukh6_id;
            $gals[$r++] = $bukh7_id;
            $gals[$r++] = $bukh8_id;
            $gals[$r++] = $bukh9_id;
            $gals[$r++] = $bukh10_id;
            $ind = 0;
            for($i = $id; $i < 10; $i++)
            {
                $gals[$i] = $gals[$i+1];
            }
            $gals[10] = 0;
            $gt -> update(array('bukh1_id' => $gals[1],'bukh2_id' => $gals[2], 'bukh3_id' => $gals[3], 
            'bukh4_id' => $gals[4], 'bukh5_id' => $gals[5], 'bukh6_id' => $gals[6],'bukh7_id' => $gals[7], 
            'bukh8_id' => $gals[8], 'bukh9_id' => $gals[9], 'bukh10_id' => $gals[10]), 'ezen_id = '.$uid);
            $ret = array();
            echo Zend_Json :: encode($ret);
    }
    public function contestAction()
    {
            $uid = Zend_Registry::get('uid');
            $contests = new Model_DbTable_Contest;
            $tmp = 0;
            $this->view->contest_prev = $contests -> fetchAll($contests -> select() -> where('active ='. $tmp ));               
            $tmp = 1;
            $this->view->contest_next = $contests -> fetchAll($contests -> select() -> where('active ='. $tmp ));
    }
    public function contestaddAction()
    {
        $form = new Form_Contestadd();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $name = $this -> _request -> getParam('name');
                $start_date = $this -> _request -> getParam('start_date');
                $end_date = $this -> _request -> getParam('end_date');

                $contest = new Model_DbTable_Contest();
                $tmp = 0;
                $contest -> insert(array('name' => $name,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'active' => $tmp));
                $this -> _redirect('fantasy/contest');
            }

        }
        $form -> setAction('contestadd');
        $this -> view -> form = $form;
    }
    public function contestmoreAction()
    {
        $uid = Zend_Registry::get('uid');

        $id = $this -> _request -> getParam('id');
        $this -> view -> dugaar = $id;
        $q = $this -> _request -> getParam('q');

        if($q == 'signup')
        {
            $this -> view -> is = 'signup';
        }
        if($q == 'rating')
        {
            $this -> view -> is = 'rating';
        }
        if($q == 'davaa')
        {
            $this -> view -> is = 'davaa';
        }   
        $tmp = 0;
        $davaas = new Model_DbTable_Davaa;
        $this -> view -> davaa = $davaas -> fetchAll($davaas -> select() -> where('fantasy_id ='.$id.' AND active ='.$tmp));
        $tmp = 1;   
        $this -> view -> davaaduussan = $davaas -> fetchAll($davaas -> select() -> where('fantasy_id ='.$id.' AND active ='.$tmp));
        $fantasys = new Model_DbTable_Fantasy;
        $fantasy=$fantasys->fetchAll($fantasys->select()->where('id='.$id));
        foreach ($fantasy as $key => $value) {
            $this->view->fantasyname = $value['name']; 
        }
        $users = new Model_DbTable_Users;
        $this -> view -> user = $users -> fetchAll($users -> select());
        
        $gals = new Model_DbTable_Gal;
        $this -> view -> galuud = $gals -> fetchAll($gals -> select());

        $this -> view -> gal = $gals -> fetchAll($gals -> select() -> where('ezen_id ='.$uid));  
        $gald = $gals -> fetchAll($gals -> select() -> where('ezen_id ='.$uid));              
        $gid = 0;
        foreach ($gald as $key => $value) {
            $gid = $value['id'];
        }
        $scores = new Model_DbTable_Score;
        $this -> view -> rating = $scores -> fetchAll($scores -> select() -> where('fantasyid ='.$id) -> order('total_score DESC'));
        $this -> view -> score = $scores -> fetchAll($scores -> select() -> where('galid ='.$gid.' AND fantasyid='.$id));

        $form = new Form_Comment();
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
        $this -> view -> form = $form; 


        $news = new Model_DbTable_News();
        $this -> view -> news = $news -> fetchAll($news -> select() -> where('isactive = 1') -> order('isping DESC') -> order('date DESC'));
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

    
    }
    public function ajaxpostsubmitAction()
    {
        
    }
    public function ajaxcontestmoreorohguiAction()
    {
        $id = $this -> _request -> getParam('id');
        $this->_redirect('index/index');
        $ret = array();
        echo Zend_Json :: encode($ret);
    }
    public function ajaxcontestmoreornoAction() 
    {
        $id = $this -> _request -> getParam('id');
        $galid = $this -> _request -> getParam('galid');
        $score = new Model_DbTable_Score;

        $gals = new Model_DbTable_Gal;
        $gal = $gals -> fetchAll($gals -> select() -> where('id = '.$galid));
        
        $cnt = 0;
        $score -> insert(array('galid' => $galid, 'fantasyid' => $id,'total_score' => $cnt));
        $ret = array();
        echo Zend_Json :: encode($ret);        
    }
    public function ajaxfantasyactiveAction()
    {
        
        $id = $this -> _request -> getParam('id');
        $barildaan_id = $this -> _request -> getParam('barildaan_id');

        $davaas = new Model_DbTable_Davaa;
        $davaa = $davaas -> fetchAll($davaas -> select() -> where('fantasy_id = '.$id));
        $mx = 0;
        foreach ($davaa as $key => $value) {
            if($mx < $value['davaa_num']) $mx = $value['davaa_num'];
        }
        $mx++;
        $tmp = 0;
        $davaas -> insert(array('barildaan_id' => $barildaan_id, 'davaa_num' => $mx, 'fantasy_id' => $id, 'active' => $tmp));
        
        $gals = new Model_DbTable_Score;
        $gal = $gals -> fetchAll($gals -> select() -> where('fantasyid = '.$id));
        $davaas = new Model_DbTable_Davaagal;
        
        $galuud = new Model_DbTable_Gal;
        $galS = $galuud -> fetchAll($galuud -> select());
        $galid = 0;
        foreach ($gal as $key => $value) {
            $galid = $value['galid'];
            foreach ($galS as $key => $val) {
                if($val['id'] == $galid)
                {
                    $davaas -> insert(array('bukh1_id' => $val['bukh1_id'],
                    'bukh2_id' => $val['bukh2_id'],
                    'bukh3_id' => $val['bukh3_id'],
                    'bukh4_id' => $val['bukh4_id'],
                    'bukh5_id' => $val['bukh5_id'],
                    'bukh6_id' => $val['bukh6_id'],
                    'bukh7_id' => $val['bukh7_id'],
                    'bukh8_id' => $val['bukh8_id'],
                    'bukh9_id' => $val['bukh9_id'],
                    'bukh10_id' => $val['bukh10_id'],
                    'gal_id' => $galid,
                    'fantasy_id' => $id,
                    'davaa_num' => $mx
                    ));    
                }
             } 
        }
        $ret = array();
        echo Zend_Json :: encode($ret);        
    }
    public function davaaaddAction()
    {
        $id = $this -> _request -> getParam('id');
        $barildaan_id = $this -> _request -> getParam('barildaan_id');
    }
    public function ajaxdavaaresultAction()
    {
        $davaa_num = $this -> _request -> getParam('davaa_num');
        $fantasy_id = $this -> _request -> getParam('fantasy_id');
        
        $galuud = new Model_DbTable_Gal;
        $gal = $galuud -> fetchAll($galuud -> select());
        $galname = array();
        $galezenid = array();
        foreach ($gal as $key => $value) {
            $galname[$value['id']] = $value['name'];
            $galezenid[$value['id']] = $value['ezen_id'];
        }
        $users = new Model_DbTable_Users;
        $user = $users -> fetchAll($users -> select());
        $usr = array();
        foreach ($user as $key => $value) {
            $usr[$value['id']] = $value['lastname'].' '.$value['firstname']; 
        }
        $davaas = new Model_DbTable_Davaagal;
        $davaa = $davaas -> fetchAll($davaas -> select() -> where('fantasy_id = '.$fantasy_id.' AND davaa_num = '.$davaa_num) -> order('score DESC'));
        $galid = 0; $cnt = 5;
        $ret = array();
        foreach ($davaa as $key => $val) {
            $ret[] = array('galname' => $galname[$val['gal_id']], 'score' => $val['score'], 'username' => $usr[$galezenid[$val['gal_id']]], 'galid' => $val['gal_id'],'davaa' => $davaa_num);
        }    
        echo Zend_Json :: encode($ret);    
    }
    public function ajaxteamviewAction()
    {
        $davaa = $this -> _request -> getParam('davaa');
        $fantasy_id = $this -> _request -> getParam('fantasy_id'); 
        $galid = $this -> _request -> getParam('galid');  
        $ret = array();
        $davaas = new Model_DbTable_Davaagal;
        $davaad = $davaas -> fetchAll($davaas -> select() -> where('fantasy_id ='. $fantasy_id.' and davaa_num ='. $davaa.' and gal_id = '. $galid));
        
        foreach ($davaad as $key => $value) {
            $ret[] = array('score' => $value['score'], 'bukh1_id' => $value['bukh1_id'],  
                'bukh2_id' => $value['bukh2_id'], 'bukh3_id' => $value['bukh3_id'], 'bukh4_id' => $value['bukh4_id'],
                'bukh5_id' => $value['bukh5_id'], 'bukh6_id' => $value['bukh6_id'], 'bukh7_id' => $value['bukh7_id'],
                'bukh8_id' => $value['bukh8_id'], 'bukh9_id' => $value['bukh9_id'], 'bukh10_id' => $value['bukh10_id']);
        }

        echo Zend_Json :: encode($ret);  
    }
    public function ajaxdavaascoreAction()
    {
        $davaa_num = $this -> _request -> getParam('davaa_num');
        $fantasy_id = $this -> _request -> getParam('fantasy_id');

        $onoo = new Model_DbTable_Score;

        $ds = new Model_DbTable_Davaa;
        $dd = $ds -> fetchAll($ds -> select() -> where('fantasy_id ='.$fantasy_id.' AND davaa_num ='.$davaa_num));
        $barildaan = 0;
        foreach ($dd as $key => $value) {
            $barildaan = $value['barildaan_id'];
        }
        $onoolts = new Model_DbTable_Onoolt;
        $onoolt = $onoolts -> fetchAll($onoolts -> select() -> where('barildaan_id ='.$barildaan));


        $bukhs = new Model_DbTable_Bukh;
        $tsols = new Model_DbTable_Tsol;
        $tsoluud = array();
        $tsol = $tsols -> fetchAll($tsols -> select());
        for($i = 0; $i<1000; $i++) {
            $tsoluud[$i] = 0;
        }
        foreach ($tsol as $key => $value) {
            $tsoluud[$value['id']] = $value['score'];
        }
        //Энд галуудын фантази оноог тооцоолно
        $davaagals = new Model_DbTable_Davaagal;
        $davaa = $davaagals -> fetchAll($davaagals -> select() -> where('fantasy_id = '.$fantasy_id.' AND davaa_num = '.$davaa_num));             
        foreach ($davaa as $key => $val) {

            $bukh1_id = $val['bukh1_id'];
            $bukh2_id = $val['bukh2_id'];
            $bukh3_id = $val['bukh3_id'];
            $bukh4_id = $val['bukh4_id'];
            $bukh5_id = $val['bukh5_id'];
            $bukh6_id = $val['bukh6_id'];
            $bukh7_id = $val['bukh7_id'];
            $bukh8_id = $val['bukh8_id'];
            $bukh9_id = $val['bukh9_id'];
            $bukh10_id = $val['bukh10_id'];
            $galid = $val['gal_id'];
            $score = 0;

            $bukh1score = 0;
            $bukh2score = 0;
            $bukh3score = 0;
            $bukh4score = 0;
            $bukh5score = 0;
            $bukh6score = 0;
            $bukh7score = 0;
            $bukh8score = 0;
            $bukh9score = 0;
            $bukh10score = 0;
            
            foreach ($onoolt as $key => $on) {
                if($on['bukh1_id'] == $bukh1_id || $on['bukh2_id'] == $bukh1_id)
                {
                    $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id ='.$on['bukh1_id'].' OR id = '.$on['bukh2_id']));
                    foreach ($bukh as $key => $bb) {
                        if($bb['id'] == $on['bukh1_id'])
                            $bukh1_tsolid = $bb['tsolid'];
                        else 
                            $bukh2_tsolid = $bb['tsolid'];
                    }
                    if($on['bukh1_id'] == $bukh1_id)
                    {
                        if($on['davsanbukh_id'] == $bukh1_id)
                        {
                            $bukh1score += ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*20 + 1000;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh1score -= ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*10 + 300;
                        }
                    }
                    else
                    {
                        if($on['davsanbukh_id'] == $bukh1_id)
                        {
                            $bukh1score += ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*20 + 1000;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh1score -= ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*10 + 300;
                        }                        
                    }
                }

                if($on['bukh1_id'] == $bukh2_id || $on['bukh2_id'] == $bukh2_id)
                {
                    $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id ='.$on['bukh1_id'].' OR id = '.$on['bukh2_id']));
                    foreach ($bukh as $key => $bb) {
                        if($bb['id'] == $on['bukh1_id'])
                            $bukh1_tsolid = $bb['tsolid'];
                        else 
                            $bukh2_tsolid = $bb['tsolid'];
                    }
                    if($on['bukh1_id'] == $bukh2_id)
                    {
                        if($on['davsanbukh_id'] == $bukh2_id)
                        {
                            $bukh2score += ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh2score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh2score -= ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*10 + 300;
                        }
                    }
                    else
                    {
                        if($on['davsanbukh_id'] == $bukh2_id)
                        {
                            $bukh2score += ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh2score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh2score -= ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*10 + 300;
                        }                        
                    }
                }
                ////////////////////////////////////////////////////////////////////////////////////////
                if($on['bukh1_id'] == $bukh3_id || $on['bukh2_id'] == $bukh3_id)
                {
                    $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id ='.$on['bukh1_id'].' OR id = '.$on['bukh2_id']));
                    foreach ($bukh as $key => $bb) {
                        if($bb['id'] == $on['bukh1_id'])
                            $bukh1_tsolid = $bb['tsolid'];
                        else 
                            $bukh2_tsolid = $bb['tsolid'];
                    }
                    if($on['bukh1_id'] == $bukh3_id)
                    {
                        if($on['davsanbukh_id'] == $bukh3_id)
                        {
                            $bukh3score += ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh3score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh3score -= ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*10 + 300;
                        }
                    }
                    else
                    {
                        if($on['davsanbukh_id'] == $bukh3_id)
                        {
                            $bukh3score += ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh3score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh3score -= ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*10 + 300;
                        }                        
                    }
                }
/////////////////////////////////////////////////////////////////////////////////////////
                if($on['bukh1_id'] == $bukh4_id || $on['bukh2_id'] == $bukh4_id)
                {
                    $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id ='.$on['bukh1_id'].' OR id = '.$on['bukh2_id']));
                    foreach ($bukh as $key => $bb) {
                        if($bb['id'] == $on['bukh1_id'])
                            $bukh1_tsolid = $bb['tsolid'];
                        else 
                            $bukh2_tsolid = $bb['tsolid'];
                    }
                    if($on['bukh1_id'] == $bukh4_id)
                    {
                        if($on['davsanbukh_id'] == $bukh4_id)
                        {
                            $bukh4score += ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh4score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh4score -= ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*10 + 300;
                        }
                    }
                    else
                    {
                        if($on['davsanbukh_id'] == $bukh4_id)
                        {
                            $bukh4score += ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh4score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh4score -= ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*10 + 300;
                        }                        
                    }
                }
/////////////////////////////////////////////////////////////////////////////////////////
                if($on['bukh1_id'] == $bukh5_id || $on['bukh2_id'] == $bukh5_id)
                {
                    $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id ='.$on['bukh1_id'].' OR id = '.$on['bukh2_id']));
                    foreach ($bukh as $key => $bb) {
                        if($bb['id'] == $on['bukh1_id'])
                            $bukh1_tsolid = $bb['tsolid'];
                        else 
                            $bukh2_tsolid = $bb['tsolid'];
                    }
                    if($on['bukh1_id'] == $bukh5_id)
                    {
                        if($on['davsanbukh_id'] == $bukh5_id)
                        {
                            $bukh5score += ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh5score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh5score -= ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*10 + 300;
                        }
                    }
                    else
                    {
                        if($on['davsanbukh_id'] == $bukh5_id)
                        {
                            $bukh5score += ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh5score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh5score -= ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*10 + 300;
                        }                        
                    }
                }
/////////////////////////////////////////////////////////////////////////////////////////
                if($on['bukh1_id'] == $bukh6_id || $on['bukh2_id'] == $bukh6_id)
                {
                    $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id ='.$on['bukh1_id'].' OR id = '.$on['bukh2_id']));
                    foreach ($bukh as $key => $bb) {
                        if($bb['id'] == $on['bukh1_id'])
                            $bukh1_tsolid = $bb['tsolid'];
                        else 
                            $bukh2_tsolid = $bb['tsolid'];
                    }
                    if($on['bukh1_id'] == $bukh6_id)
                    {
                        if($on['davsanbukh_id'] == $bukh6_id)
                        {
                            $bukh6score += ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh6score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh6score -= ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*10 + 300;
                        }
                    }
                    else
                    {
                        if($on['davsanbukh_id'] == $bukh6_id)
                        {
                            $bukh6score += ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh6score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh6score -= ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*10 + 300;
                        }                        
                    }
                }   
/////////////////////////////////////////////////////////////////////////////////////////
                if($on['bukh1_id'] == $bukh7_id || $on['bukh2_id'] == $bukh7_id)
                {
                    $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id ='.$on['bukh1_id'].' OR id = '.$on['bukh2_id']));
                    foreach ($bukh as $key => $bb) {
                        if($bb['id'] == $on['bukh1_id'])
                            $bukh1_tsolid = $bb['tsolid'];
                        else 
                            $bukh2_tsolid = $bb['tsolid'];
                    }
                    if($on['bukh1_id'] == $bukh7_id)
                    {
                        if($on['davsanbukh_id'] == $bukh7_id)
                        {
                            $bukh7score += ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh7score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh7score -= ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*10 + 300;
                        }
                    }
                    else
                    {
                        if($on['davsanbukh_id'] == $bukh7_id)
                        {
                            $bukh7score += ($tsoluud[$on['bukh1_id']] - $tsoluud[$on['bukh2_id']])*20 + 1000;
                            if($on['davaa_num'] > 1) $bukh7score += $on['davaa_num']*100;
                        }
                        else
                        {
                            if($on['davaa_num'] > 1)
                                $bukh7score -= ($tsoluud[$on['bukh2_id']] - $tsoluud[$on['bukh1_id']])*10 + 300;
                        }                        
                    }
                }                           
            }
            $score = $bukh1score + $bukh2score + $bukh3score + $bukh4score + $bukh5score 
            + $bukh6score + $bukh7score;
            $kk = 1;
            $davaagals -> update(array('score' => $score), 'fantasy_id ='.$fantasy_id.' and davaa_num ='.$davaa_num.' and gal_id ='.$galid);    
            $ds -> update(array('active' => $kk), 'fantasy_id ='.$fantasy_id.' and davaa_num ='.$davaa_num);   
            $oo = $onoo -> fetchAll($onoo -> select() -> where('fantasyid ='.$fantasy_id.' and galid ='.$galid));
            $total = 0;
            foreach ($oo as $key => $value) {
                $total = $value['total_score'];
            }
            $total += $score;
            $onoo -> update(array('total_score' => $total), 'fantasyid ='.$fantasy_id.' and galid ='.$galid);
        }
        $ret = array();
        echo Zend_Json :: encode($ret);  
    }
}


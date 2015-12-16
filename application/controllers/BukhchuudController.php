<?php

class BukhchuudController extends Zend_Controller_Action
{

    public function saveImage($source,$username,$ex)
    {
        $image = file_get_contents($source);    
        $name = $username;
        $dir = APPLICATION_PATH.'/../public/images/profile/'. $name .'.'. $ex;
        file_put_contents($dir, $image);
    }
	public function saveImage1($source,$username,$ex)
    {
        $image = file_get_contents($source);    
        $name = $username;
        $dir = APPLICATION_PATH.'/../public/images/photos/'.$name.'.'.$ex;
        file_put_contents($dir, $image);
    }
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

        $tsols = new Model_DbTable_Tsol();
        $this -> view -> tsol = $tsols -> fetchAll($tsols -> select()); 

        $sums = new Model_DbTable_Sum();
        $this -> view -> sum = $sums -> fetchAll($sums -> select());        

        $aimags = new Model_DbTable_Aimag();
        $this -> view -> aimag = $aimags -> fetchAll($aimags -> select());

        $bukhs = new Model_DbTable_Bukh();
        $this -> view -> bukh = $bukhs -> fetchAll($bukhs -> select() -> order('tsolid ASC'));
        


    }
    public function addAction()
    {
        $form = new Form_Bukh();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                
                $obog = $this -> _request -> getParam('obog');
                $ner = $this -> _request -> getParam('ner');
                $date = $this -> _request -> getParam('date');
                $tsoldate = $this -> _request -> getParam('tsoldate');
                $aimag = $this -> _request -> getParam('aimag');
                $sum = $this -> _request -> getParam('sum');
                $tsol = $this -> _request -> getParam('tsol');
                $sponsor = $this -> _request -> getParam('sponsor');
                $uri = "images/profile/default.jpg";
                $bukh = new Model_DbTable_Bukh();
                $bukhs = $bukh -> fetchAll($bukh -> select());
                $uid = 0;
                foreach ($bukhs as $val) {
                    $uid = $val['id'];
                }
                $uid++;
                if ($form->image->isUploaded() && $form->image->receive()){
                    $extension = pathinfo($form->image->getFileName(), PATHINFO_EXTENSION);
                    $uri = "images/profile/".$uid.".".$extension;
                    $this -> saveImage($form->image->getFileName(),$uid,$extension);
                }
                $bukh -> insert(array('lname' => $obog,
                        'fname' => $ner,
                        'date' => $date,
                        'tsoldate' => $tsoldate,
                        'aimagid' => $aimag,
                        'sumid' => $sum,
                        'tsolid' => $tsol,
                        'sponsor' => $sponsor,
                        'uri' => $uri
                    ));
                $this -> _redirect('bukhchuud/index');
            }
        }

        $form -> setAction('add');
        $this -> view -> form = $form;
    }

    public function ajaxAction() {
        $id = $this -> _request -> getParam('id');
        $model = new Model_DbTable_Sum();
        $res = $model -> fetchAll($model -> select() -> where('aimagid = ' . $id) -> order('name'));
        $ret = array();
        foreach ($res as $key => $value) {
            $ret[] = array('id' => $value -> id, 'name' => $value -> name);
        }
        echo Zend_Json :: encode($ret);
    }
    public function pageAction() {
        $id = $this -> _request -> getParam('id');
        $this -> view -> dugaar = $id;
		$q = $this -> _request -> getParam('q');
		
        $barildaans = new Model_DbTable_Barildaan();
        $this -> view -> barildaan = $barildaans -> fetchAll($barildaans -> select());
        
        $bukhs = new Model_DbTable_Bukh();
        $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id = '.$id));

        $onoolts = new Model_DbTable_Onoolt();
        $this -> view -> onoolt = $onoolts -> fetchAll($onoolts -> select());

        foreach ($bukh as $key => $value) {
            $this -> view -> lname = $value['lname'];
            $this -> view -> fname = $value['fname'];    
        }
		if($q == 'photos')
		{
			$this -> view -> is = 'photos';
		}
		if($q == 'videos')
		{
			$this -> view -> is = 'videos';
		}
        if($q == 'barildaan')
        {
            $this -> view -> is = 'barildaan';
        }        

		$form = new Form_Addphotos();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
            	
                if ($form->image->isUploaded() && $form->image->receive()){
                    $extension = pathinfo($form->image->getFileName(), PATHINFO_EXTENSION);
					$images = new Model_DbTable_Images();
					$image = $images -> fetchAll($images -> select() -> where('bukhid = ' . $id));
					$cnt = 0;
					foreach ($image as $key => $val) {
						if($cnt < $val['url']) $cnt = $val['url'];
					}
					$cnt=$cnt%100000; $cnt++;
					$picture = $id*100000 + $cnt;
					$images -> insert(array('bukhid' => $id, 'url' => $picture, 'ex' => $extension));
                    $this -> saveImage1($form->image->getFileName(),$picture,$extension);
                }	
				$this -> _redirect('bukhchuud/page/id/'.$id.'/q/photos');
            }
        }

        $form -> setAction('page');
        $this -> view -> form = $form;
    }
    public function ajaxprofilechangeAction()
    {
        $id = $this->_request->getParam('bukh');
        $ret = array();
        echo Zend_Json :: encode($ret);
    }
    public function deleteAction()
    {
        $id = $this->_request->getParam('id');
        $uid = Zend_Registry :: get('uid');
        $bukh = new Model_DbTable_Bukh();
        if (Zend_Registry :: get('role') == 'moderators' || Zend_Registry :: get('role') == 'admins')
        { 
            $bukh -> delete('id = '.$id);
        }
        $this->_redirect('bukhchuud/index');       
    }
    public function photosAction()
    {
        $id = $this->_request->getParam('id');
        $uid = Zend_Registry :: get('uid');
    }
	public function ajaximageurlAction() {
        $id = $this -> _request -> getParam('id');
        $ret = array();
		$ret[] = array('id' => $id);
        echo Zend_Json :: encode($ret);
    }
    public function ajaxbukhvsAction() {
        $bid = $this -> _request -> getParam('barildaan');
        $bukh = $this -> _request -> getParam('bukh');
        $this -> view -> bukh = $bukh; 
        $onoolts = new Model_DbTable_Onoolt();
        $this -> view -> onoolt = $onoolts -> fetchAll($onoolts -> select() -> where('barildaan_id = '.$bid));
        $this -> bk = new Model_DbTable_Bukh();
        $bukhvs = new Model_DbTable_Onoolt();
        $this -> view -> bukhvs = $bukhvs -> fetchAll($bukhvs -> select());
    }
    public function ajaxbukhvs100Action()
    {
        $b1_id = $this -> _request -> getParam('bukh1');
        $b2_id = $this -> _request -> getParam('bukh2');   

        $this->view->b1_id = $b1_id;
        $this->view->b2_id = $b2_id;     

        $bukhvs = new Model_DbTable_Onoolt();
        $this -> view -> bukhvs = $bukhvs -> fetchAll($bukhvs -> select());  
        $barildaans = new Model_DbTable_Barildaan();
        $this -> view -> barildaan = $barildaans -> fetchAll($barildaans -> select());       
    }
    public function ajaxbukhsearchAction()
    {
        $id = $this -> _request -> getParam('id');
        
        $tsols = new Model_DbTable_Tsol();
        $tsol = $tsols -> fetchAll($tsols -> select());
        $ret = array();
        foreach ($tsol as $key => $value) {
            $ret[] = array('id' => $value['id'], 'name' => $value['name']);
        }
        echo Zend_Json :: encode($ret);
    }
    public function editAction()
    {
        $id = $this -> _request -> getParam('id'); 
        $form = new Form_Bukh();
        $request = $this -> getRequest();
        if ($request -> isPost()) {
            if ($form -> isValid($this -> _request -> getPost())) {

                $lname = $this -> _request -> getParam('obog');
                $fname = $this -> _request -> getParam('ner');
                $date = $this -> _request -> getParam('date');
                $tsoldate = $this -> _request -> getParam('tsoldate');
                $sponsor = $this -> _request -> getParam('sponsor');
                
                $bukhchuud = new Model_DbTable_Bukh();
                $bukhchuud -> update(array('lname' => $lname, 'fname' => $fname, 'date' => $date,
                'tsoldate' => $tsoldate, 'sponsor' => $sponsor), 'id = ' . $id);
                $this -> _redirect('bukhchuud/index');
            }
        }
        $bukhchuud = new Model_DbTable_Bukh();
        $res = $bukhchuud -> fetchAll($bukhchuud -> select() -> where('id = ' . $id));
        foreach ($res as $val) {
            $form -> obog -> setValue($val["lname"]);
            $form -> ner -> setValue($val["fname"]);
            $form -> date -> setValue($val["date"]);
            $form -> tsol -> setValue($val["tsolid"]);
            $form -> tsoldate -> setValue($val["tsoldate"]);
            $form -> aimag -> setValue($val["aimagid"]);
            $form -> sum -> setValue($val["sumid"]);
            $form -> sponsor -> setValue($val["sponsor"]);
        }
        $form -> add -> setLabel("Засварлах");
        $form -> setAction('../../edit/id/' . $id);
        $this -> view -> form = $form;
    }
    public function deleteajaxAction()
    {
        $id = $this -> _request -> getParam('id'); 
        $ret = array();
        $ret[] = array('id' => $id);
        echo Zend_Json :: encode($ret);   
    }
    public function ajaxdeletebukhAction()
    {
        $id = $this -> _request -> getParam('id'); 
        $bukhchuud = new Model_DbTable_Bukh();
        $bukhchuud -> delete('id = ' . $id);
        $ret = array();
        echo Zend_Json :: encode($ret); 
    }
}


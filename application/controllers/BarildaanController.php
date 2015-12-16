
<?php

class BarildaanController extends Zend_Controller_Action
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
        $bukhs = new Model_DbTable_Barildaan();
        $tmp = 1;
        $chin = 1;
        $dp = 2;
        $q = $bukhs -> fetchAll($bukhs -> select() -> where('active ='.$tmp.' OR active ='.$dp));
        $paginator=Zend_Paginator::factory($q);
        $paginator->setItemCountPerPage(15)
                  ->setCurrentPageNumber($this->_getParam('page', 1));
        $this->view->medee=$paginator;
        $tmp = 0;
        $this->view->medee1 = $bukhs -> fetchAll($bukhs -> select() -> where('active ='.$tmp));
    }
    public function addAction()
    {
        $form = new Form_Barildaan();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                
                $name = $this -> _request -> getParam('name');
                $date = $this -> _request -> getParam('date');
                $category = $this -> _request -> getParam('category');
                $bukh_num = $this -> _request -> getParam('bukh_num');
                $loc = $this -> _request -> getParam('loc');
                $active = 0;
                $aimags = new Model_DbTable_Aimag();
                $aimag = $aimags -> fetchAll($aimags -> select() -> where('id = '.$loc));
                foreach ($aimag as $key => $val) {
                    $location = $val['name'];
                } 
                $barildaan = new Model_DbTable_Barildaan();
                $barildaan -> insert(array('name' => $name,
                    'date' => $date,
                    'category' => $category,
                    'active' => $active,
                    'bukh_number' => $bukh_num,
                    'location' => $location,
                ));
                $this -> _redirect('barildaan/index');
            }
        }

        $form -> setAction('add');
        $this -> view -> form = $form;
    }
    public function moreAction()
    {
        $id = $this -> _request -> getParam('id');
        $barildaan = new Model_DbTable_Barildaan();
        $this -> view -> barildaan = $barildaan -> fetchAll($barildaan -> select() -> where('id = '.$id));
        $this -> view -> dugaar = $id;
        $burtgels = new Model_DbTable_Burtgel();
        $this -> view -> burtgel = $burtgels -> fetchAll($burtgels -> select() -> where('barildaan_id = '.$id));
        $bukhs = new Model_DbTable_Bukh();
        $this -> view -> bukh = $bukhs -> fetchAll($bukhs -> select());
        $onoolts = new Model_DbTable_Onoolt();
        $this-> view -> onoolt = $onoolts -> fetchAll($onoolts -> select() -> where('barildaan_id = '. $id));
        $davaa = $barildaan -> fetchAll($barildaan -> select() -> where('id = '.$id));
        foreach ($davaa as $key => $value){
            $this -> view -> code = $value['davaa_id'];
        }
    }
    public function deleteAction()
    {
        $id = $this -> _request -> getParam('id');
        $barildaan = new Model_DbTable_Barildaan();
        $barildaan -> delete('id = '.$id);
        $this -> _redirect('barildaan/index');
    }
    public function bukh_addAction()
    {
        $form = new Form_Barildaanbukhadd();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                
                $name = $this -> _request -> getParam('name');
                $date = $this -> _request -> getParam('date');
                $category = $this -> _request -> getParam('category');
                $bukh_num = $this -> _request -> getParam('bukh_num');
                $loc = $this -> _request -> getParam('loc');
                $active = 0;
                $aimags = new Model_DbTable_Aimag();
                $aimag = $aimags -> fetchAll($aimags -> select() -> where('id = '.$loc));
                foreach ($aimag as $key => $val) {
                    $location = $val['name'];
                } 
                $barildaan = new Model_DbTable_Barildaan();
                $barildaan -> insert(array('name' => $name,
                    'date' => $date,
                    'category' => $category,
                    'active' => $active,
                    'bukh_number' => $bukh_num,
                    'location' => $location,
                ));
                $this -> _redirect('barildaan/index');
            }
        }

        $form -> setAction('add');
        $this -> view -> form = $form;
    }
    public function editAction()
    {
        $id = $this -> _request -> getParam('id');
        $form = new Form_Barildaan();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                
                $name = $this -> _request -> getParam('name');
                $date = $this -> _request -> getParam('date');
                $category = $this -> _request -> getParam('category');
                $bukh_num = $this -> _request -> getParam('bukh_num');
                $loc = $this -> _request -> getParam('loc');

                $aimags = new Model_DbTable_Aimag();
                $aimag = $aimags -> fetchAll($aimags -> select() -> where('id = '.$loc));
                foreach ($aimag as $key => $val) {
                    $location = $val['name'];
                } 
                $barildaan = new Model_DbTable_Barildaan();
                $barildaan -> update(array('name' => $name,
                    'date' => $date,
                    'category' => $category,
                    'bukh_number' => $bukh_num,
                    'location' => $location,
                ), 'id =' . $id);
                $this -> _redirect('barildaan/index');
            }
        }
        $barildaan = new Model_DbTable_Barildaan();
        $br = $barildaan -> fetchAll($barildaan -> select() -> where('id ='.$id));
        foreach ($br as $key => $val) {
            $form -> name -> setValue($val["name"]);
            $form -> category -> setValue($val["category"]);
            $form -> date -> setValue($val["date"]);
            $form -> bukh_num -> setValue($val["bukh_number"]);
            $form -> loc -> setValue($val["location"]);
        }
        $form -> add -> setLabel("Засварлах");
        $form -> setAction('../../edit/id/' . $id);
        $this -> view -> form = $form;
    }
    public function ajaxAction() {
        $result = $this -> _request -> getParam('text');
        $bukhs = new Model_DbTable_Bukh();
        $bukh = $bukhs -> fetchAll($bukhs -> select());
        $ret = array();
        $len = strlen($result);
        foreach ($bukh as $key => $value) {
            $str = $value['fname'];
            $lent = strlen($str);
            if($lent >= $len)
            {
                $tmp = 1;
                for($i=0; $i<$len; $i++) {
                    if($str[$i] != $result[$i]){ $tmp = 0; break; }
                }
                if($tmp == 1) $ret[] = array('id' => $value['id'], 'lname' => $value['lname'],'fname' => $value['fname']); 
            }
        }
        echo Zend_Json :: encode($ret);
    }
    public function ajaxbukh1Action() {

            $result = $this -> _request -> getParam('text');
            $barildaan = $this -> _request -> getParam('barildaan');
            $davaa = $this -> _request -> getParam('davaa');
            $bukhs = new Model_DbTable_Bukh();
            $bukh = $bukhs -> fetchAll($bukhs -> select());        
            if($davaa == 1)
            {
                $brtgls = new Model_DbTable_Burtgel();
                $brtgl = $brtgls -> fetchAll($brtgls -> select() -> where('barildaan_id = '.$barildaan));
                $ret = array();
                $len = strlen($result);
                foreach ($bukh as $key => $value) {
                    $tmp = 0;
                    foreach ($brtgl as $key => $on) 
                    {

                        if($on['bukh_id'] == $value['id'])
                        {
                            $tmp++;
                        }            
                    }
                    if($tmp == 1)
                    {
                        $str = $value['fname'];
                        $lent = strlen($str);
                        if($lent >= $len)
                        {
                            $tmp = 1;
                            for($i=0; $i<$len; $i++) {
                                if($str[$i] != $result[$i]){ $tmp = 0; break; }
                            }
                            if($tmp == 1) $ret[] = array('id' => $value['id'], 'lname' => $value['lname'],'fname' => $value['fname']); 
                        }
                    }
                }   
                echo Zend_Json :: encode($ret);
            }
            else
            {
                $onoolts = new Model_DbTable_Onoolt();
                $onoolt = $onoolts -> fetchAll($onoolts -> select() -> where('barildaan_id = '.$barildaan));
                $ret = array();
                $len = strlen($result);
                foreach ($bukh as $key => $value) {
                    $tmp = 0;
                    foreach ($onoolt as $key => $on) 
                    {

                        if($on['davaa_num'] == ($davaa - 1) && $on['davsanbukh_id'] == $value['id'])
                        {
                            $tmp++;
                        }   
                        if($on['davaa_num'] == $davaa)
                        {
                            if($on['bukh1_id'] == $value['id'] || $on['bukh2_id'] == $value['id'])
                            {
                                $tmp++;
                            }
                        }             
                    }
                    if($tmp == 1)
                    {
                        $str = $value['fname'];
                        $lent = strlen($str);
                        if($lent >= $len)
                        {
                            $tmp = 1;
                            for($i=0; $i<$len; $i++) {
                                if($str[$i] != $result[$i]){ $tmp = 0; break; }
                            }
                            if($tmp == 1) $ret[] = array('id' => $value['id'], 'lname' => $value['lname'],'fname' => $value['fname']); 
                        }
                    }
                }   
                echo Zend_Json :: encode($ret);
            }
    }
    public function ajaxbukh2Action() {
            $result = $this -> _request -> getParam('text');
            $barildaan = $this -> _request -> getParam('barildaan');
            $davaa = $this -> _request -> getParam('davaa');
            $bukhs = new Model_DbTable_Bukh();
            $bukh = $bukhs -> fetchAll($bukhs -> select());        
            if($davaa == 1)
            {
                $brtgls = new Model_DbTable_Burtgel();
                $brtgl = $brtgls -> fetchAll($brtgls -> select() -> where('barildaan_id = '.$barildaan));
                $ret = array();
                $len = strlen($result);
                foreach ($bukh as $key => $value) {
                    $tmp = 0;
                    foreach ($brtgl as $key => $on) 
                    {

                        if($on['bukh_id'] == $value['id'])
                        {
                            $tmp++;
                        }            
                    }
                    if($tmp == 1)
                    {
                        $str = $value['fname'];
                        $lent = strlen($str);
                        if($lent >= $len)
                        {
                            $tmp = 1;
                            for($i=0; $i<$len; $i++) {
                                if($str[$i] != $result[$i]){ $tmp = 0; break; }
                            }
                            if($tmp == 1) $ret[] = array('id' => $value['id'], 'lname' => $value['lname'],'fname' => $value['fname']); 
                        }
                    }
                }   
                echo Zend_Json :: encode($ret);
            }
            else
            {
                $onoolts = new Model_DbTable_Onoolt();
                $onoolt = $onoolts -> fetchAll($onoolts -> select() -> where('barildaan_id = '.$barildaan));
                $ret = array();
                $len = strlen($result);
                foreach ($bukh as $key => $value) {
                    $tmp = 0;
                    foreach ($onoolt as $key => $on) 
                    {

                        if($on['davaa_num'] == ($davaa - 1) && $on['davsanbukh_id'] == $value['id'])
                        {
                            $tmp++;
                        }   
                        if($on['davaa_num'] == $davaa)
                        {
                            if($on['bukh1_id'] == $value['id'] || $on['bukh2_id'] == $value['id'])
                            {
                                $tmp++;
                            }
                        }             
                    }
                    if($tmp == 1)
                    {
                        $str = $value['fname'];
                        $lent = strlen($str);
                        if($lent >= $len)
                        {
                            $tmp = 1;
                            for($i=0; $i<$len; $i++) {
                                if($str[$i] != $result[$i]){ $tmp = 0; break; }
                            }
                            if($tmp == 1) $ret[] = array('id' => $value['id'], 'lname' => $value['lname'],'fname' => $value['fname']); 
                        }
                    }
                }   
                echo Zend_Json :: encode($ret);
            }
    }        
    public function ajaxtableAction() {
        $result = $this -> _request -> getParam('id');
        $ret = array();
        
        $bukhs = new Model_DbTable_Bukh();
        $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id = '.$result));
        foreach ($bukh as $key => $value) {
            
            $id = $value['id'];
            $lname = $value['lname'];
            $fname = $value['fname'];
            
        }
        $ret[] = array('id' => $id, 'lname' => $lname, 'fname' => $fname);
        echo Zend_Json :: encode($ret);
    }
    public function ajaxtable1Action() {
        $result = $this -> _request -> getParam('id');
        $ret = array();
        
        $bukhs = new Model_DbTable_Bukh();
        $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id = '.$result));
        foreach ($bukh as $key => $value) {
            
            $id = $value['id'];
            $lname = $value['lname'];
            $fname = $value['fname'];
            
        }
        $ret[] = array('id' => $id, 'lname' => $lname, 'fname' => $fname);
        echo Zend_Json :: encode($ret);
    }
    public function ajaxtable2Action() {
        $result = $this -> _request -> getParam('id');
        $ret = array();
        
        $bukhs = new Model_DbTable_Bukh();
        $bukh = $bukhs -> fetchAll($bukhs -> select() -> where('id = '.$result));
        foreach ($bukh as $key => $value) {
            
            $id = $value['id'];
            $lname = $value['lname'];
            $fname = $value['fname'];
            
        }
        $ret[] = array('id' => $id, 'lname' => $lname, 'fname' => $fname);
        echo Zend_Json :: encode($ret);
    }    
    public function ajaxbukhaddAction() {
        $id = $this -> _request -> getParam('id');
        $barildaan = $this -> _request -> getParam('barildaan');
        
        $burtgel = new Model_DbTable_Burtgel();
        $brtl = $burtgel -> fetchAll($burtgel -> select() -> where('bukh_id = '.$id.' AND barildaan_id = '.$barildaan));
        $cnt = 0;
        foreach ($brtl as $key => $value) {
            $cnt++;
        }
        $ret = array();
        $st = 0;
        if($cnt == 0)
        {
            $st = 1;
            $burtgel -> insert(array('bukh_id' => $id,'barildaan_id' => $barildaan
            ));
            $ret[] = array('status' => $st);
        }
        else
        {
            $st = 0;
            $ret[] = array('status' => $st);
        }
        echo Zend_Json :: encode($ret);
    }
    public function ajaxbarildaanstartAction() {
        $id = $this -> _request -> getParam('id');
        $barildaan = new Model_DbTable_Barildaan();
        $cnt = 1;
        $barildaan -> update(array('active' => $cnt,'davaa_id' => $cnt), 'id = ' . $id);
        $ret = array();

        echo Zend_Json :: encode($ret);
    }
    public function ajaxdavaanegonooltAction()
    {
        $num1 = $this -> _request -> getParam('num1');
        $num2 = $this -> _request -> getParam('num2');
        $barildaan = $this -> _request -> getParam('barildaan');
        $bukh1_lname = $this -> _request -> getParam('bukh1_lname');
        $bukh1_fname = $this -> _request -> getParam('bukh1_fname');
        $bukh2_lname = $this -> _request -> getParam('bukh2_lname');
        $bukh2_fname = $this -> _request -> getParam('bukh2_fname');

        $onoolt = new Model_DbTable_Onoolt();
        $onoolt -> insert(array('bukh1_id' => $num1, 'bukh2_id' => $num2, 'barildaan_id' => $barildaan,'davaa_num' => 1,
        'bukh1_lname' => $bukh1_lname, 'bukh1_fname' => $bukh1_fname, 'bukh2_lname' => $bukh2_lname, 'bukh2_fname' => $bukh2_fname));
        $burtgel = new Model_DbTable_Burtgel();
        $burtgel->delete('bukh_id ='.$num1.' AND barildaan_id ='.$barildaan);
        $burtgel->delete('bukh_id ='.$num2.' AND barildaan_id ='.$barildaan);        
        $ret = array();
        echo Zend_Json :: encode($ret);
    }
    public function ajaxdavaanuudonooltAction()
    {
        $num1 = $this -> _request -> getParam('num1');
        $num2 = $this -> _request -> getParam('num2');
        $barildaan = $this -> _request -> getParam('barildaan');
        $davaa = $this -> _request -> getParam('davaa');
        $bukh1_lname = $this -> _request -> getParam('bukh1_lname');
        $bukh1_fname = $this -> _request -> getParam('bukh1_fname');
        $bukh2_lname = $this -> _request -> getParam('bukh2_lname');
        $bukh2_fname = $this -> _request -> getParam('bukh2_fname');
        
        $onoolt = new Model_DbTable_Onoolt();
        $onoolt -> insert(array('bukh1_id' => $num1, 'bukh2_id' => $num2, 'barildaan_id' => $barildaan,'davaa_num' => $davaa,
        'bukh1_lname' => $bukh1_lname, 'bukh1_fname' => $bukh1_fname, 'bukh2_lname' => $bukh2_lname, 'bukh2_fname' => $bukh2_fname
            ));
        $ret = array();
        echo Zend_Json :: encode($ret);
    }
    public function ajaxstartdavaanegAction()
    {
        $id = $this -> _request -> getParam('id');
        $barildaan = new Model_DbTable_Barildaan();
        $cnt = 1;
        $barildaan -> update(array('davaa_active' => $cnt), 'id = ' . $id);
        $ret = array();
        echo Zend_Json :: encode($ret);
    }
    public function ajaxstartdavaanuudAction()
    {
        $id = $this -> _request -> getParam('id');
        $barildaan = new Model_DbTable_Barildaan();
        $cnt = 1;
        $barildaan -> update(array('davaa_active' => $cnt), 'id = ' . $id);
        $ret = array();
        echo Zend_Json :: encode($ret);
    }
    public function ajaxfinishbarildaanAction()
    {
        $id = $this -> _request -> getParam('id');
        $barildaan = new Model_DbTable_Barildaan();
        $cnt = 2;
        $barildaan -> update(array('active' => $cnt), 'id = ' . $id);
        $ret = array();
        echo Zend_Json :: encode($ret);
    }
    public function ajaxbukhresultAction()
    {
        $id = $this -> _request -> getParam('id');
        $bukh2_mod = $id % 1000000;
        $bukh2_id = $id % 1000000;
        $id = $id - $bukh2_mod;
        $bukh1_id = $id / 1000000;
        $bukhs = new Model_DbTable_Bukh();
        $bukh = $bukhs -> fetchAll($bukhs -> select());
        $ret = array();
        $bukh1_lname = "";
        $bukh1_fname = "";
        $bukh2_lname = "";
        $bukh2_fname = "";
        foreach ($bukh as $key => $value) {
            if($value['id'] == $bukh1_id)
            {
                $bukh1_lname = $value['lname'];
                $bukh1_fname = $value['fname'];
                $bukh1_id = $value['id'];
            }
            if($value['id'] == $bukh2_id)
            {
                $bukh2_lname = $value['lname'];
                $bukh2_fname = $value['fname'];
                $bukh2_id = $value['id'];
            }
        }
        $ret[] = array('bukh1_lname' => $bukh1_lname, 'bukh1_fname' => $bukh1_fname, 'bukh2_lname' => $bukh2_lname, 'bukh2_fname' => $bukh2_fname, 'bukh1_id' => $bukh1_id, 'bukh2_id' => $bukh2_id);
        echo Zend_Json :: encode($ret);
    }
    public function ajaxbukh1chooserAction()
    {
        $id = $this -> _request -> getParam('id');
        $ret = array();
        $ret[] = array('id' => $id);
        echo Zend_Json :: encode($ret);
    }
    public function ajaxbukh2chooserAction()
    {
        $id = $this -> _request -> getParam('id');
        $ret = array();
        $ret[] = array('id' => $id);
        echo Zend_Json :: encode($ret);
    }
    public function ajaxnextdavaaAction()
    {
        $barildaan  = $this -> _request -> getParam('id');
        $onoolts = new Model_DbTable_Barildaan();
        $onoolt = $onoolts -> fetchAll($onoolts -> select() -> where('id = '. $barildaan));
        foreach ($onoolt as $key => $value) {
            $cnt = $value['davaa_id'];
        }
        $cnt++;
        $ans = 0;
        $onoolts -> update(array('davaa_id' => $cnt,'davaa_active' => $ans), 'id = ' . $barildaan);
        $ret = array();
        echo Zend_Json :: encode($ret);
    }
    public function ajaxbukhresultfinishAction()
    {
        $id1 = $this -> _request -> getParam('id1');
        $id2 = $this -> _request -> getParam('id2');
        $text = $this -> _request -> getParam('text');
        $davsan_bukh = $this -> _request -> getParam('davsanbukh_id');
        $barildaan = $this -> _request -> getParam('barildaan');
        $davaa = $this -> _request -> getParam('davaa');
        $onoolt = new Model_DbTable_Onoolt();
        $onoolt -> update(array('davsanbukh_id' => $davsan_bukh, 'mekh' => $text), 'bukh1_id = '.$id1.' and bukh2_id = '.$id2.' and barildaan_id = '.$barildaan.' and davaa_num = '.$davaa);
        $ret[] = array();
        echo Zend_Json :: encode($ret);
    }
}

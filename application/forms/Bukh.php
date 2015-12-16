<?php
	class Form_Bukh extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('Bukh');
			$this->setAttrib('class','input-group');
			$obog = new Zend_Form_Element_Text('obog');
			$obog -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Бөхийн овог")
			          ->setRequired()
			          ->setLabel("Дүн.мн бөх бүртгэх хэсэг");
			$ner = new Zend_Form_Element_Text('ner');
			$ner -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Бөхийн нэр")
			          ->setRequired();
			$date = new Zend_Form_Element_Text('date');
			$date -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Бөхийн төрсөн он (он-сар-өдөр)")
			          ->setRequired();

			$tsol = new Zend_Form_Element_Select("tsol");  //create obj
			$tsol -> setAttrib('class', "form-control")
				   -> setRequired()
				   -> setLabel("Та цолоо сонгоно уу?");


        	$db = Zend_Registry :: get('db');

			$sql = $db->quoteInto('select * from tsol',null);
			$users = $db->query($sql)->fetchAll();

			
			$first = NULL;
			foreach ($users as $user){
				if ($first == NULL) $first = $user["id"];
			    $tsol -> addMultiOption($user['id'], $user['name']);
			}


			$tsoldate = new Zend_Form_Element_Text('tsoldate');
			$tsoldate -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Цол авсан өдөр (он-сар-өдөр)")
			          ->setRequired();
			

			$aimag = new Zend_Form_Element_Select('aimag');  //create obj
			$aimag -> setAttrib('class', "form-control")
				   -> setRequired()
				   -> setLabel("Та аймагаа сонгоно уу?");


        	$db = Zend_Registry :: get('db');

			$sql = $db->quoteInto('select * from aimag',null);
			$users = $db->query($sql)->fetchAll();

			
			$first = 0;
			foreach ($users as $user){
				if ($first == 0) $first = $user['id'];
			    $aimag -> addMultiOption($user['id'], $user['name']);
			}

			$sum = new Zend_Form_Element_Select("sum");  //create obj
			$sum -> setAttrib('class', "form-control")
				   -> setRequired()
				   -> setLabel("Та сумаа сонгоно уу?")
				   -> setregisterInArrayValidator(false);

			$sql = $db->quoteInto('select * from sum WHERE aimagid = ' . $first, null);
			$users = $db->query($sql)->fetchAll();

			$userArray = array();
			foreach ($users as $user){
				$sum -> addMultiOption($user['id'], $user['name']);
			}

			$sponsor = new Zend_Form_Element_Text('sponsor');
			$sponsor -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Ивээн тэтгэгч байгууллага")
			          -> setRequired();

			$add = new Zend_Form_Element_Submit('add');
			$add -> setLabel('Бөх бүртгэх')-> setAttrib('class', 'btn');

			$image=new Zend_Form_Element_File('image');
			$image->setLabel('Зураг оруулах:');
        	$image->addValidator('Size', false, 10240000);
        	$image->addValidator('Extension', false, 'jpg,png,gif,pdf,zip,rar');
        	$image->setAttrib('class', "form-control"); 

			$this->addElement($obog);
			$this->addElement($ner);
			$this->addElement($date);
			$this->addElement($tsol);
			$this->addElement($tsoldate);
			$this->addElement($aimag);
			$this->addElement($sum);
			$this->addElement($sponsor);
			$this->addElement($image);
			$this->addElement($add);
			$this->setMethod('post');
		}
	}

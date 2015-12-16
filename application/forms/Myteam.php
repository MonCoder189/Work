<?php
	class Form_Myteam extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('Myteam');
			$this->setAttrib('class','input-group');
			$name = new Zend_Form_Element_Text('name');
			$name -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Барилдааны нэр")
			          -> setRequired()
			          -> setLabel("Дүн.мн барилдаан үүсгэх хэсэг");

			$date = new Zend_Form_Element_Text('date');
			$date -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Барилдаан болох өдөр (он-сар-өдөр)")
			          ->setRequired();

			$category = new Zend_Form_Element_Select("category");  //create obj
			$category -> setAttrib('class', "form-control")
				   -> setRequired()
				   -> setLabel("Та барилдааны ангилал сонгоно уу?");

			$category -> addMultiOption('0','Улсын баяр наадам');
			$category -> addMultiOption('1','Цагаан сар');

			$add = new Zend_Form_Element_Submit('add');
			$add -> setLabel('Барилдаан үүсгэх')-> setAttrib('class', 'btn');

			$loc = new Zend_Form_Element_Select('loc');  //create obj
			$loc -> setAttrib('class', "form-control")
				   -> setRequired()
				   -> setLabel("Та аймагаа сонгоно уу?");


        	$db = Zend_Registry :: get('db');

			$sql = $db->quoteInto('select * from aimag',null);
			$users = $db->query($sql)->fetchAll();
			
			$first = 0;
			foreach ($users as $user){
				if ($first == 0) $first = $user['id'];
			    $loc -> addMultiOption($user['id'], $user['name']);
			}

			$bukh_num = new Zend_Form_Element_Text('bukh_num');
			$bukh_num -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Бөхийн тоо")
			          -> setRequired();

			$this->addElement($name);
			$this->addElement($date);
			$this->addElement($loc);
			$this->addElement($category);
			$this->addElement($bukh_num);
			$this->addElement($add);
			$this->setMethod('post');
		}
	}

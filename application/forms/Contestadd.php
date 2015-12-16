<?php
	class Form_Contestadd extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('Contestadd');
			$this->setAttrib('class','input-group');
			$name = new Zend_Form_Element_Text('name');
			$name -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Тэмцээний нэр")
			          -> setRequired()
			          -> setLabel("Фантази тэмцээн үүсгэх хэсэг");

			$start_date = new Zend_Form_Element_Text('start_date');
			$start_date -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Тэмцээн эхлэх өдөр (он-сар-өдөр)")
			          ->setRequired();

			$end_date = new Zend_Form_Element_Text('end_date');
			$end_date -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Тэмцээн дуусах өдөр (он-сар-өдөр)")
			          ->setRequired();

			$add = new Zend_Form_Element_Submit('add');
			$add -> setLabel('Фантази үүсгэх')-> setAttrib('class', 'btn');

			$this->addElement($name);
			$this->addElement($start_date);
			$this->addElement($end_date);
			$this->addElement($add);
			$this->setMethod('post');
		}
	}

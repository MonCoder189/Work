<?php
	class Form_Tsol extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('tsol');
			
			$name = new Zend_Form_Element_Text('name');
			$name -> setLabel('Цолны нэрийг оруулна уу ?')
			       -> setRequired(true)
				   -> addFilter(new Zend_Filter_StringTrim())
    			   -> addValidator((new Zend_Validate_NotEmpty()))
    			   -> setAttrib('class', "form-control");

			$score = new Zend_Form_Element_Text('score');
			$score -> setLabel('Цолны фантази оноог оруулна уу ?')
			       -> setRequired(true)
				   -> addFilter(new Zend_Filter_StringTrim())
    			   -> addValidator((new Zend_Validate_NotEmpty()))
    			   -> setAttrib('class', "form-control");

			$add = new Zend_Form_Element_Submit('add');
			$add -> setLabel('Нэмэх')-> setAttrib('class', 'btn');

			$this->addElement($name);
			$this->addElement($score);
			$this->addElement($add);
			$this->setMethod('post');
		}
	}

<?php
	class Form_Aimag extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('aimag');
			
			$name = new Zend_Form_Element_Text('name');
			$name -> setLabel('Аймгийн нэрийг оруулна уу ?')
			       -> setRequired(true)
				   -> addFilter(new Zend_Filter_StringTrim())
    			   -> addValidator((new Zend_Validate_NotEmpty()))
    			   -> setAttrib('class', "form-control");
			
			$add = new Zend_Form_Element_Submit('add');
			$add -> setLabel('Нэмэх')-> setAttrib('class', 'btn');

			$this->addElement($name);
			$this->addElement($add);
			$this->setMethod('post');
		}
	}

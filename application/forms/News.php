<?php
	class Form_News extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('news');
			
			$title = new Zend_Form_Element_Text('title');
			$title -> setLabel('Гарчиг:')
			       -> setRequired(true)
				   -> addFilter(new Zend_Filter_StringTrim())
    			   -> addValidator((new Zend_Validate_NotEmpty()))
    			   -> setAttrib('class', "form-control");

    		$content = new Zend_Form_Element_Textarea('textcontent');
    		$content -> setLabel('Мэдээ:');

    		/*
    		$isActive = new Zend_Form_Element_Select('isactive');
		    $isActive -> setLabel("Төлөв:") -> setRequired() -> setAttrib('class', "form-control");
		    $isActive -> addMultiOption('1','Шууд нийтлэх');
			$isActive -> addMultiOption('0','Дараа нийтлэх');
			*/
			
			$add = new Zend_Form_Element_Submit('submit');
			$add -> setLabel('Мэдээ оруулах')-> setAttrib('class', 'btn') -> setAttrib('class', "form-control");
			
			$this -> addElement($title);
			$this -> addElement($content);
			//$this -> addElement($isActive);
			$this->addElement($add);
			$this->setMethod('post');
		}
	}

<?php
	class Form_Addphotos extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('Addphotos');
			$this->setAttrib('class','input-group');
			
			$image=new Zend_Form_Element_File('image');
			$image->setLabel('Зураг оруулах:');
        	$image->addValidator('Size', false, 1024000000);
        	$image->addValidator('Extension', false, 'jpg,png,gif,pdf,zip,rar');
        	$image->setAttrib('class', "form-control"); 

			
			$add = new Zend_Form_Element_Submit('add');
			$add -> setLabel('Хадгалах')-> setAttrib('class', 'btn');

			$this->addElement($image);
			$this->addElement($add);
			$this->setMethod('post');
		}
	}

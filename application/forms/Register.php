<?php
	class Form_Register extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('register');
			$this->setAttrib('class','input-group');

			$username = new Zend_Form_Element_Text('username');
			$username 
			          -> setRequired(true)
			          -> setAttrib('class', "form-control")
					  -> addFilter(new Zend_Filter_StringTrim())
    				  -> addValidator((new Zend_Validate_StringLength(4, 20)))
    				  -> addValidator('regex',true,array('/^[(a-zA-Z0-9)]+$/'))
    				  -> setAttrib('placeholder',"Хэрэглэгчийн нэр")
    				  -> addValidator('Db_NoRecordExists', true, array('table' => 'users', 'field' => 'username'))
    				  ->setLabel("Дүн.мн хэрэглэгчийн бүртгүүлэх хэсэг");

			$password = new Zend_Form_Element_Password('password');
	        $password 
	                  -> setRequired(true)
	                  -> setAttrib('placeholder',"Нууц үг")
	                  -> setAttrib('class', "form-control")
					  -> addFilter(new Zend_Filter_StringTrim())
    				  -> addValidator(new Zend_Validate_StringLength(8, 20));
	                
	        $confirmPassword = new Zend_Form_Element_Password('confirm_password');
	        $confirmPassword -> setAttrib('class', "form-control");
			
			$token = Zend_Controller_Front::getInstance()->getRequest()->getPost('password');
			
	        $confirmPassword 
	                         -> setRequired(true)
	                         -> setAttrib('placeholder',"Нууц үгээ давтана уу?")
	        				 -> setAttrib('class', "form-control")                
							 -> addFilter(new Zend_Filter_StringTrim())
    						 -> addValidator(new Zend_Validate_Identical(trim($token)));

    		$firstname = new Zend_Form_Element_Text('firstname');
    		$firstname 
    				   -> setAttrib('placeholder',"Таны нэр")
    				   -> addFilter(new Zend_Filter_StringTrim())
    				   -> addValidator(new Zend_Validate_NotEmpty())
    				   -> setAttrib('class', "form-control");

    		$lastname = new Zend_Form_Element_Text('lastname');
    		$lastname 
    				  -> setAttrib('placeholder',"Таны овог")	
    				  -> addFilter(new Zend_Filter_StringTrim())
    				  -> addValidator(new Zend_Validate_NotEmpty())
    				  -> setAttrib('class', "form-control");

    		$date = new Zend_Form_Element_Text('date');
    		$date	  -> setAttrib('placeholder',"Төрсөн он сар өдөр (он-сар-өдөр)")
    				  -> addFilter(new Zend_Filter_StringTrim())
    				  -> addValidator(new Zend_Validate_NotEmpty())
    				  -> setAttrib('class', "form-control");

    		$email = new Zend_Form_Element_Text('email');
			$email 
    			   -> addFilters(array('StringTrim', 'StripTags'))
    			   -> setAttrib('placeholder',"Таны цахим хаяг")
    			   -> addValidator('EmailAddress',  TRUE  )
    			   -> addValidator('Db_NoRecordExists', true, array('table' => 'users', 'field' => 'E-mail'))
    			   -> addValidator(new Zend_Validate_NotEmpty())
    			   -> setAttrib('class', "form-control");


			
			$submit = new Zend_Form_Element_Submit('register');
			$submit -> setLabel('Бүртгүүлэх')-> setAttrib('class', 'btn');
			
			$this -> addElement($username);
			$this -> addElement($password);
			$this -> addElement($confirmPassword);
			$this -> addElement($firstname);
			$this -> addElement($lastname);
			$this -> addElement($date);
			$this -> addElement($email);
			$this->addElement($submit);
			$this->setMethod('post');
		}
	}

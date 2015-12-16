<?php
	class Form_Login extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			

			$this->setName('login');

			$username = new Zend_Form_Element_Text('username');
			$username -> setAttrib('class', "form-control") 
					  -> setAttrib('placeholder',"Хэрэглэгчийн нэр")
			          -> setRequired(true)
			          -> setLabel("Colden compass - ийн хэрэглэгчийн нэвтрэх хэсэг")
			          -> setAttrib('class', "form-control");

			$password = new Zend_Form_Element_Password('password');
			$password -> setAttrib('class', "form-control") -> setAttrib('placeholder',"Нууц үг")
			           ->setRequired(true);
			
			$login = new Zend_Form_Element_Submit('login');
			$login->setLabel('Нэвтрэх')-> setAttrib('class', 'btn') -> setAttrib('class', "form-control");

			$this->addElement($username);
			$this->addElement($password);
			/*
			$this->addElement('captcha', 'captcha', array(
            'class' => 'form-control',
            'required'   => true,
            'placeholder' => 'Дээрхи кодыг оруулна уу',
            'captcha'    => array(
                'captcha' => 'Figlet',
                'wordLen' => 3,
                'timeout' => 300
            )
        	));
        	*/
        	$this->addElement($login);
			$this->setMethod('post');
		}
	}

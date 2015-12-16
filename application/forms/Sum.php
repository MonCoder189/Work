<?php
	class Form_sum extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('sum');
			
			$name = new Zend_Form_Element_Text('name');
			$name -> setLabel('Сумын нэрийг оруулна уу ?')
			       -> setRequired(true)
				   -> addFilter(new Zend_Filter_StringTrim())
    			   -> addValidator((new Zend_Validate_NotEmpty()))
    			   -> setAttrib('class', "form-control");

			$aimag = new Zend_Form_Element_Select("aimag");  //create obj
			$aimag -> setAttrib('class', "form-control")
				   -> setRequired()
				   -> setLabel("Та аймагаа сонгоно уу?");

            $params = array(
    		'host'           => '127.0.0.1',
    		'username'       => 'root',
    		'password'       => '',
    		'dbname'         => 'dun'
			);

        	$db = Zend_Db::factory("mysqli",$params);

			$sql = $db->quoteInto('select * from aimag',null);
			$users = $db->query($sql)->fetchAll();

			$userArray = array();
			foreach ($users as $user){
			    /*use value as the key,while form submited,key was added into response obj*/
			    $userArray[ $user['name']] = $user['name']; //create the $list
			}

			$aimag->addMultiOptions($userArray);
			
			$add = new Zend_Form_Element_Submit('add');
			$add -> setLabel('Нэмэх')-> setAttrib('class', 'btn');

			$this->addElement($aimag);
			$this->addElement($name);
			$this->addElement($add);
			$this->setMethod('post');
		}
	}

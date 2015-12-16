<?php
	class Form_Comment extends Zend_Form
	{
		public function __construct($option = null) {
			parent :: __construct($option);
			
			$this->setName('comment');

    		$content = new Zend_Form_Element_Textarea('commentbody');
    		$content -> setAttrib('rows', '6');
			$content -> setAttrib('class', 'span6');
			$content -> setAttrib('placeholder','Та сэтгэгдэлээ үлдээнэ үү?');

			$add = new Zend_Form_Element_Submit('submit');
			$add -> setLabel('Сэтгэгдэл нэмэрлэх')-> setAttrib('class', 'btn btn-primary');

			$this -> addElement($content);
			$this->addElement($add);
			$this->setMethod('post');
		}
	}

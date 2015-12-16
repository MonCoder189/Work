<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload () {
		$modelLoader = new Zend_Application_Module_Autoloader(array(
			'namespace' => '',
			'basePath' => APPLICATION_PATH));
		
		if (Zend_Auth::getInstance()->hasIdentity()) {
			Zend_Registry::set('role', Zend_Auth::getInstance()->getStorage()->read()->role);
			Zend_Registry::set('uid', Zend_Auth::getInstance()->getStorage()->read()->id);
		} else {
			Zend_Registry::set('role', 'guests');
		}

		$this -> _acl = new Model_LibraryAcl();
		Zend_Controller_Front::getInstance()-> registerPlugin(new Plugin_AccessCheck(new Model_LibraryAcl()));

		return $modelLoader;
	}

	function _initViewHelpers() {
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		$view -> doctype('HTML5');
		$view->headMeta()->appendHttpEquiv('Content-type', 'text/html;charset=UTF-8')
						  ->appendName('description', 'Zend tutorial');
		$view->headTitle("Монкодер");
		$view->headTitle()->setSeparator(' - ');

		$navContainerConfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/nav.xml', 'nav');
		$navContainer = new Zend_Navigation($navContainerConfig);
		
		$view -> navigation($navContainer) -> setAcl($this -> _acl) -> setRole(Zend_Registry::get('role'));
		$view -> navigation() -> menu();
	}
	
	protected function _initDatabase() {
        $config = $this->getOptions();
        $db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
        Zend_Db_Table::setDefaultAdapter($db);
        Zend_Registry::set("db", $db);
    }
}



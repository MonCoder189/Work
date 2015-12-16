<?php
class Model_LibraryAcl extends Zend_Acl
{
	public function __construct() {
			
			$this -> addRole(new Zend_Acl_Role('guests'));
			$this -> addRole(new Zend_Acl_Role('users'), 'guests');
			$this -> addRole(new Zend_Acl_Role('moderators'), 'users');
			$this -> addRole(new Zend_Acl_Role('admins'), 'moderators');
			
			$this -> add(new Zend_Acl_Resource('index'));
			$this -> add(new Zend_Acl_Resource('error'));
			$this -> add(new Zend_Acl_Resource('education'));
			$this -> add(new Zend_Acl_Resource('authentication'));
			$this -> add(new Zend_Acl_Resource('sport'));
			$this -> add(new Zend_Acl_Resource('niitlel'));
			$this -> add(new Zend_Acl_Resource('other'));
			$this -> add(new Zend_Acl_Resource('user'));
			$this -> add(new Zend_Acl_Resource('bukhchuud'));
			$this -> add(new Zend_Acl_Resource('barildaan'));
			$this -> add(new Zend_Acl_Resource('fantasy'));
			$this -> add(new Zend_Acl_Resource('aimag'));
			$this -> add(new Zend_Acl_Resource('sum'));
			$this -> add(new Zend_Acl_Resource('tsol'));

			$this -> allow('guests', 'bukhchuud', array('index','page','ajaxbukhsearch'));
			$this -> allow('guests', 'barildaan', array('index','more'));
			$this -> allow('guests', 'fantasy', array('index'));
			$this -> allow('guests', 'error', array('error'));
			$this -> allow('guests', 'index', array('index','add','more'));
			$this -> allow('guests', 'education', array('index'));
			$this -> allow('guests', 'sport', array('index'));
			$this -> allow('guests', 'other', array('index'));
			$this -> allow('guests', 'authentication', array('login','loginfacebook','register'));
			$this -> allow('guests', 'niitlel', array('index'));
			
			$this -> allow('users', 'authentication', array('logout'));
			$this -> allow('users', 'user', array('mypage'));	
			$this -> allow('users', 'fantasy', array('ajaxmyteambukhadd','myteam',
				'ajaxtablefantasymyteam','ajaxtablefantasymyteam2','ajaxmyteamadd',
				'ajaxmyteamsort','myteamchange','teamadd','naimaa','ajaxnaimaadeletebukh',
				'ajaxnaimaabukhzarah','naimaaaddbukh','ajaxnaimaabukhavah','contestadd',
				'contest','contestmore','ajaxcontestmoreorohgui','ajaxcontestmoreorno',
				'ajaxfantasyactive', 'ajaxdavaaresult', 'ajaxdavaascore', 'ajaxteamview'));

			$this -> allow('moderators','bukhchuud',array('add', 'ajax','ajaximageurl','edit',
				'delete',
				'photos','ajaxbukhvs','ajaxbukhvs100','ajaxprofilechange',
				'deleteajax', 'ajaxdeletebukh'));
			$this -> allow('moderators','aimag',array('index','add','edit','remove'));
			$this -> allow('moderators','sum',array('index','add','edit','remove'));
			$this -> allow('moderators','tsol',array('index','add'));
			$this -> allow('moderators','barildaan',array('delete','add','edit','ajax',
				'ajaxtable','ajaxbukhadd','ajaxbarildaanstart','ajaxbukh1','ajaxbukh2'
				,'ajaxtable1','ajaxtable2','ajaxdavaanegonoolt','ajaxstartdavaaneg',
				'ajaxbukhresult','ajaxbukh1chooser','ajaxbukh2chooser',
				'ajaxbukhresultfinish','ajaxnextdavaa','ajaxdavaanuudonoolt',
				'ajaxstartdavaanuud','ajaxfinishbarildaan'));
	}
}
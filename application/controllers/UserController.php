<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    public function mypageAction()
    {
        $id = $this -> _request -> getParam('id');
        $this -> view -> dugaar = $id;
    }
    public function ratingAction()
    {
        // action body
    }
    public function settingsAction()
    {
        // action body
    }
}


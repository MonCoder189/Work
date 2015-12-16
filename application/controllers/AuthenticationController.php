<?php

class AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        if (Zend_Auth :: getInstance()->hasIdentity()) {
            $this->_redirect('index/index');
        }
        $form = new Form_Login();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $authAdapter = $this->getAdapter();
                $username = $form->getValue('username');
                $password = $form->getValue('password');
                
                $authAdapter->setIdentity($username)
                            ->setCredential($password);
                echo 'start';
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                echo 'end';
                if ($result->isValid()) {
                    $identity = $authAdapter->getResultRowObject();
                    $authStorage = $auth->getStorage();
                    $authStorage->write($identity);
                    echo 'ok';
                    //$this->_redirect('index/index');
                }
                else {
                    echo 'no';
                    $this->view->errorMessage = '<ul class="error"><li>Username or password is wrong!</li></ul>';
                }
            } 
        }
        $form -> setAction('../authentication/login');
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index/index');
    }

    private function getAdapter()
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password');
        return $authAdapter;
    }
    
    public function registerAction()
    {
        $form = new Form_Register();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $username = $this -> _request -> getParam('username');
                $password = $this -> _request -> getParam('password');
                $firstname = $this -> _request -> getParam('firstname');
                $lastname = $this -> _request -> getParam('lastname');
                $date = $this -> _request -> getParam('date');
                $email = $this -> _request -> getParam('email');
                $users = new Model_DbTable_Users();
                $users -> insert(array('username' => $username,
                        'password' => md5($password),
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'E-mail' => $email,
                        'date' => $date,
                        'role' => 'users',
                        'country' => 'Монгол',
                        'uri' => 'images/profile/default.jpg'
                    ));
                    $this -> _redirect('authentication/login');
            }
        }

        $form -> setAction('../authentication/register');
        $this -> view -> form = $form;
    }

    public function loginfacebookAction()
    {
        //$facebook = Zend_Registry::get('Facebook');
        //$user = $facebook->getUser();
                
        /*if ($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $facebook->api('/me');
            } catch (Facebook_Api_Exception $e) {
                $user = null;
            }
        }
                
        // Login or logout url will be needed depending on current user state.
        if ($user) {
            $logoutUrl = $facebook->getLogoutUrl();
            $this->view->link = $logoutUrl;
            $this->view->user = $user_profile;
        } else {
            $loginUrl = $facebook->getLoginUrl(array('scope' => 'email,publish_stream'));
            $this->view->link = $loginUrl;
        }*/
    }
}


<?php
App::uses('AppController', 'Controller');

class TemplatesController extends AppController {
    function beforeFilter() {
        parent::beforeFilter();

        $userInfo = $this->Session->read('user_info');
        if(empty($userInfo)) {
            $this->redirect('/');
            exit;
        }
    }

    function index() {
        $list = $this->Template->query("select * from templates");
        $this->set('list', $list);
    }

} 
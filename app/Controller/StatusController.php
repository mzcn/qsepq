<?php
App::uses('AppController', 'Controller');

class StatusController extends AppController {
    function beforeFilter() {
        parent::beforeFilter();

        $userInfo = $this->Session->read('user_info');
        if(empty($userInfo)) {
            $this->redirect('/');
            exit;
        }
    }

    function index() {
        $list = $this->Status->query("select * from statuses");
        $this->set('list', $list);
    }
} 
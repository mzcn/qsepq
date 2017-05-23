<?php
App::uses('AppController', 'Controller');

class ProjectsController extends AppController {
    function beforeFilter() {
        parent::beforeFilter();

        $userInfo = $this->Session->read('user_info');
        if(empty($userInfo)) {
            $this->redirect('/');
            exit;
        }
    }

    function index() {
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];
        $list = $this->Project->query("select * from projects where company_id=$company_id");
        $this->set('list', $list);
    }

    function add() {
        $userInfo = $this->Session->read('user_info');
        $this->set('company_id', $userInfo['company_id']);

        if ($this->request->is('post')) {
            $this->Project->create();
            if ($this->Project->save($this->request->data)) {
                echo "<script>alert('保存成功！');window.location.href='/projects';</script>";
            }
        }
    }

    function edit() {
        $id = $this->request->query('id');

        if ($this->request->is('get')) {
            $data = $this->Project->query("select * from projects where id=$id");
            $this->set('item', current($data));
        } else {
            if ($this->Project->save($this->request->data)) {
                echo "<script>alert('编辑成功！');window.location.href='/projects';</script>";
            } else {
                echo "<script>alert('编辑失败！');window.location.href='/projects/edit?id=$id';</script>";
            }
        }
    }

    function delete() {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        if (!empty($id) && $this->Project->delete($id)) {
            echo "<script>alert('删除成功！');window.location.href='/projects';</script>";
        }
    }

    function checkExist() {
        $this->layout = 'ajax';

        $name = $this->request->query('name');
        $id = $this->request->query('id');
        $name = trim($name);
        $id = trim($id);
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];

        if(empty($id) || $id=='undefined') {
            $data = $this->Project->query("select * from projects where name='$name' and company_id=$company_id");
        } else {
            $data = $this->Project->query("select * from projects where id!=$id and name='$name' and company_id=$company_id");
        }

        if (!empty($data)) {
            echo 'exist';
            exit;
        } else {
            echo 'ok';
            exit;
        }

        echo 'error';
        exit;
    }
} 
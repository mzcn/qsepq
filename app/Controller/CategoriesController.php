<?php
App::uses('AppController', 'Controller');
App::uses('Pager', 'Lib');


class CategoriesController extends AppController {
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
        $list = $this->Category->query("select * from categories where company_id=$company_id");
        $this->set('list', $list);
    }

    function add() {
        $userInfo = $this->Session->read('user_info');
        $this->set('company_id', $userInfo['company_id']);

        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                echo "<script>alert('保存成功！');window.location.href='/categories';</script>";
            }
        }
    }

    function edit() {
        $id = $this->request->query('id');

        if ($this->request->is('get')) {
            $data = $this->Category->query("select * from categories where id=$id");
            $this->set('item', current($data));
        } else {
            if ($this->Category->save($this->request->data)) {
                echo "<script>alert('编辑成功！');window.location.href='/categories';</script>";
            } else {
                echo "<script>alert('编辑失败！');window.location.href='/categories/edit?id=$id';</script>";
            }
        }
    }

    function delete() {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        if (!empty($id) && $this->Category->delete($id)) {
            echo "<script>alert('删除成功！');window.location.href='/categories';</script>";
        }
    }

    function checkExist() {
        $this->layout = 'ajax';

        $name = $this->request->query('name');
        $id = $this->request->query('id');
        $company_id = $this->request->query('company_id');
        $name = trim($name);
        $id = trim($id);

        if(empty($id) || $id=='undefined') {
            $data = $this->Category->query("select * from categories where name='$name' and company_id=$company_id");
        } else {
            $data = $this->Category->query("select * from categories where id!=$id and name='$name' and company_id=$company_id");
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
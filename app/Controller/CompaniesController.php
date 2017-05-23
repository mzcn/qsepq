<?php
App::uses('AppController', 'Controller');

class CompaniesController extends AppController {
    function beforeFilter() {
        parent::beforeFilter();

        $userInfo = $this->Session->read('user_info');
        if(empty($userInfo)) {
            $this->redirect('/');
            exit;
        }
    }

    function index() {
        $list = $this->Company->query("select * from companies");
        $this->set('list', $list);
    }

    function add() {
        if ($this->request->is('post')) {
            $this->Company->create();
            if ($this->Company->save($this->request->data)) {
                echo "<script>alert('保存成功！');window.location.href='/companies';</script>";
            }
        }
    }

    function edit() {
        $id = $this->request->query('id');
        if ($this->request->is('get')) {
            $data = $this->Company->query("select * from companies where id=$id");
            $this->set('item', current($data));
        } else {
            $data = $this->request->data;
            if ($this->Company->save($data)) {
                $default_company = $this->Session->read('company_info');

                if($default_company['id'] == $data['id']) {
                    $company_info = array('id' => $data['id'],
                        'name' => $data['company_name'],
                        'bj_index'=> $data['baojia_abbre'],
                        'bj_length'=> $data['baojia_length'],
                        'mx_index'=> $data['mingxi_abbre'],
                        'mx_length'=> $data['mingxi_length']);

                    $this->Session->write('company_info', $company_info);
                }

                echo "<script>alert('编辑成功！');window.location.href='/companies';</script>";
            } else {
                echo "<script>alert('编辑失败！');window.location.href='/companies/edit?id=$id';</script>";
            }
        }
    }

    function delete() {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        $default_company = $this->Session->read('company_info');
        if($default_company['id'] == $id) {
            echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
            echo "<script>alert('无法删除登录默认的公司！');window.location.href='/companies';</script>";
            exit;
        }

        if (!empty($id) && $this->Company->delete($id)) {
            echo "<script>alert('删除成功！');window.location.href='/companies';</script>";
            exit;
        }
    }

    function checkExist() {
        $this->layout = 'ajax';

        $name = $this->request->query('name');
        $id = $this->request->query('id');
        $name = trim($name);
        $id = trim($id);

        if(empty($id) || $id=='undefined') {
            $data = $this->Company->query("select * from companies where company_name='$name'");
        } else {
            $data = $this->Company->query("select * from companies where id!=$id and company_name='$name'");
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
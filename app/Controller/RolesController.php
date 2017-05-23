<?php
App::uses('AppController', 'Controller');

class RolesController extends AppController {
    function beforeFilter() {
        parent::beforeFilter();

        $userInfo = $this->Session->read('user_info');
        if(empty($userInfo)) {
            $this->redirect('/');
            exit;
        }
    }

    function index() {
        $menus = $this->Role->query("select * from menus");
        $menu_hash = array();
        foreach($menus as $item) {
            $id = $item['menus']['menu_id'];
            $val = $item['menus']['menu_name'];
            $menu_hash[$id] = $val;
        }

        $list = $this->Role->query("select * from roles");
	    $list_arr = array();
        foreach($list as $item) {
            $arr = explode(',',$item['roles']['rights']);
            $tmp = '';
            foreach($arr as $item1) {
                if(!empty($item1)) {
                    $tmp .= $menu_hash[$item1].',';
                }
            }
            if(!empty($tmp)) {
                $tmp = substr($tmp, 0, strlen($tmp) - 1);
            }
            $list_arr[] = array('role_id'=> $item['roles']['role_id'], 'role_name'=> $item['roles']['role_name'], 'rights'=>$tmp);
        }
        $this->set('list', $list_arr);
    }

    function add() {
        $menus = $this->Role->query("select * from menus");
        $this->set('list', $menus);

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $rights = '';
            foreach($menus as $menu) {
                $id = $menu['menus']['menu_id'];
                if(!empty($data[$id]) && $data[$id] == 'on') {
                    $rights .= $id.',';
                }
            }

            $this->Role->query("insert into roles(role_name,remark,rights) values('".$data['role_name']."', '".$data['remark']."', '$rights')");
            echo "<script>alert('保存成功！');window.location.href='/roles';</script>";
        }
    }

    function edit() {
        $id = $this->request->query('id');
        $menus = $this->Role->query("select * from menus");
        $this->set('list', $menus);

        if ($this->request->is('get')) {
            $item = array();
            $data = $this->Role->query("select * from roles where role_id=$id");
            $data = current($data);
            $item['role_id'] = $data['roles']['role_id'];
            $item['role_name'] = $data['roles']['role_name'];
            $item['remark'] = $data['roles']['remark'];
            $item['rights'] = explode(',', $data['roles']['rights']);

            $this->set('role', $item);
        } else {
            $data = $this->request->data;
            $rights = '';
            foreach($menus as $menu) {
                $menu_id = $menu['menus']['menu_id'];
                if(!empty($data[$menu_id]) && $data[$menu_id] == 'on') {
                    $rights .= $menu_id.',';
                }
            }
            $this->Role->query("update roles set role_name='".$data['role_name']."', remark='".$data['remark']."',rights= '$rights' where role_id='$data[role_id]'");
            echo "<script>alert('编辑成功！');window.location.href='/roles';</script>";
        }
    }

    function delete() {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        if (!empty($id)) {
            $this->Role->query("delete from roles where role_id='$id'");
            echo "<script>alert('删除成功！');window.location.href='/roles';</script>";
        }
    }

    function checkExist() {
        $this->layout = 'ajax';

        $name = $this->request->query('name');
        $id = $this->request->query('id');
        $name = trim($name);
        $id = trim($id);

        if(empty($id) || $id=='undefined') {
            $data = $this->Role->query("select * from roles where role_name='$name'");
        } else {
            $data = $this->Role->query("select * from roles where role_id!=$id and role_name='$name'");
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

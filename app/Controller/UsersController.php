<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
    function index() {
        $this->layout = 'ajax';
        $this->set('error', "");

        //check session
        $userInfo = $this->Session->read('user_info');
        if(!empty($userInfo)) {
            $this->redirect('/baojias/home');
        }

        //check company
        $company_arr = $this->User->query('select * from companies');
        $companies = array();
        $company_info = array('id' => '0', 'name' => '易普趣', 'bj_index'=> '', 'bj_length'=> '5', 'mx_index'=> '', 'mx_length'=> '5');
        foreach($company_arr as $val) {
            $selected = '';
            if($val['companies']['is_default'] == '1') {
                $company_info = array('id' => $val['companies']['id'],
                    'name' => $val['companies']['company_name'],
                    'bj_index'=> $val['companies']['baojia_abbre'],
                    'bj_length'=> $val['companies']['baojia_length'],
                    'mx_index'=> $val['companies']['mingxi_abbre'],
                    'mx_length'=> $val['companies']['mingxi_length']);
                $selected = 'selected';
            }
            $companies[] = array('id' => $val['companies']['id'], 'name' => $val['companies']['company_name'], 'selected' => $selected);
        }
        $this->set('com_list', $companies);
        $this->Session->write('company_info', $company_info);
        $this->set('company_info', $company_info);

        $data = $this->request->data;
        if(!empty($data)) {
            $result = $this->User->query("select u.*,r.role_name from users u, roles r where u.username='$data[email]' and u.password='".md5($data['password'])."' and u.role_id=r.role_id");
            $result = current($result);
            if(empty($result)) {
                $this->set('error', "用户名或者密码错误！");
            } else {
                $com_arr = explode(',', $result['u']['company_ids']);
                if(!in_array($data['company'], $com_arr)) {
                    $this->set('error', "您不属于该公司的用户！");
                } else {
                    $this->Session->write('user_info',
                        array(
                            'username'=> $result['u']['username'],
                            'role' =>  $result['r']['role_name'],
                            'role_id' => $result['u']['role_id'],
                            'company_id' => $data['company']));
                    foreach($company_arr as $val) {
                        if($val['companies']['id'] == $data['company']) {
                            $company_info = array('id' => $val['companies']['id'],
                                'name' => $val['companies']['company_name'],
                                'bj_index'=> $val['companies']['baojia_abbre'],
                                'bj_length'=> $val['companies']['baojia_length'],
                                'mx_index'=> $val['companies']['mingxi_abbre'],
                                'mx_length'=> $val['companies']['mingxi_length']);
                            break;
                        }
                    }
                    $this->Session->write('company_info', $company_info);
                    $this->redirect('/baojias/home');
                }
            }
        }
    }

    function logout() {
        $this->Session->delete('user_info');
        $this->Session->delete('company_info');
        $this->redirect('/');
    }

    function userlist() {
        $list = $this->User->query("select users.*,roles.role_name from users, roles where users.role_id= roles.role_id");
        $this->set('list', $list);
    }
    
    function add() {
        $users = $this->User->query("select * from users");
        $this->set('users', $users);

        $roles = $this->User->query("select * from roles");
        $this->set('roles', $roles);

        $companies = $this->User->query("select * from companies");
        $this->set('companies', $companies);

        if ($this->request->is('post')) {
            $this->User->create();
            $data = $this->request->data;

            $company_ids = '';
            foreach($data as $key => $val) {
                if(strpos($key, 'company_') !== false && strpos($key, 'company_') == 0) {
                    $company_ids .= substr($key, 8).',';
                }
            }
            if(!empty($company_ids)) {
                $company_ids = substr($company_ids, 0, strlen($company_ids) - 1);
            }
            $data['company_ids'] = $company_ids;

            $data['password'] = md5($data['password']);
            if ($this->User->save($data)) {
                echo "<script>alert('保存成功！');window.location.href='/users/userlist';</script>";
            }
        }
    }

    function edit() {
        $id = $this->request->query('id');
        $roles = $this->User->query("select * from roles");
        $this->set('roles', $roles);

        $companies = $this->User->query("select * from companies");
        $this->set('companies', $companies);

        if ($this->request->is('get')) {
            $data = $this->User->query("select * from users where id=$id");
            $this->set('user', current($data));
        } else {
            $data = $this->request->data;
            if(isset($data['confirm_password']) && $data['confirm_password'] != '') {
                $data['password'] = md5($data['password']);
            } else {
                $info = $this->User->query("select * from users where id=$data[id]");
                $info = current($info);
                $data['password'] = $info['users']['password'];
            }

            $company_ids = '';
            foreach($data as $key => $val) {
                if(strpos($key, 'company_') !== false && strpos($key, 'company_') == 0) {
                    $company_ids .= substr($key, 8).',';
                }
            }
            if(!empty($company_ids)) {
                $company_ids = substr($company_ids, 0, strlen($company_ids) - 1);
            }
            $data['company_ids'] = $company_ids;

            if ($this->User->save($data)) {
                echo "<script>alert('编辑成功！');window.location.href='/users/userlist';</script>";
            } else {
                echo "<script>alert('编辑失败！');window.location.href='/users/edit?id=$id';</script>";
            }
        }
    }

    function delete() {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        if (!empty($id) && $this->User->delete($id)) {
            echo "<script>alert('删除成功！');window.location.href='/users/userlist';</script>";
        }
    }

    function checkExist() {
        $this->layout = 'ajax';

        $name = $this->request->query('name');
        $id = $this->request->query('id');
        $name = trim($name);
        $id = trim($id);

        if(empty($id) || $id=='undefined') {
            $data = $this->User->query("select * from users where username='$name'");
        } else {
            $data = $this->User->query("select * from users where id!=$id and username='$name'");
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

    public function userinfo() {
        $userinfo = $this->Session->read('user_info');
        $username = $userinfo['username'];

        $userinfo = $this->User->query("select * from users where username='$username'");
        $userinfo = current($userinfo);
        $this->set('userinfo', $userinfo);

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $set_var1 = '';
            $set_var2 = '';
            $set_var3 = '';
            if($data['confirm_password']) {
                $password = md5($data['password']);
                $set_var1 = "password='$password',";
            }

            if($data['email']) {
                $set_var2 = "email='".$data['email']."',";
            }

            if($data['telephone']) {
                $set_var2 = "telephone='".$data['telephone']."',";
            }

            $this->User->query("update users set $set_var1 $set_var2 $set_var3 where username='$username'");
            echo "<script>alert('更新成功！');window.location.href='/users/userinfo';</script>";
        }
    }
} 

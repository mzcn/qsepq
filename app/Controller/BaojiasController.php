<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class BaojiasController extends AppController
{
    function beforeFilter() {
        parent::beforeFilter();

        $userInfo = $this->Session->read('user_info');
        if(empty($userInfo)) {
            $this->redirect('/');
            exit;
        }
    }

    function send_email($to, $bianhao)
    {
        $Email = new CakeEmail("smtp");
        $Email->template('default', 'default');
        $Email->emailFormat('html');
        $Email->from(array('15950099188@163.com' => 'BaoJia'));
        $Email->to($to);
        $Email->subject('状态变更通知');
        $content = "你好,\n";
        $content = $content . "报价单，编号：" . $bianhao . "，状态变更，请尽快处理。\n";
        $Email->viewVars(array('content' => $content));
        $Email->send();
    }

    /**
     * 用于Dashboard
     */
    function home()
    {
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];

        $list = $this->Baojia->query("select b.*,s.* from baojias b left join statuses s on b.status=s.id where b.status=4 and company_id=$company_id");
        $this->set('list', $list);
    }

    /*
     * 报价管理
     */
    function index()
    {
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];

        $keyword = $this->request->query('keyword');
        $sql = "select b.*,s.* from baojias b left join statuses s on b.status=s.id where company_id=$company_id";
        if (!empty($keyword)) {
            $sql .= " where b.baojia_id like '%$keyword%' or name like '%$keyword%'";
        }
        $list = $this->Baojia->query($sql);
        $this->set('list', $list);
        $this->set('keyword', $keyword);
    }

    function add()
    {
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];
        $this->set('company_id', $company_id);

        $company_info = $this->Session->read('company_info');
        $bj_abbre = $company_info['bj_index'];
        $bj_length = $company_info['bj_length'];
        if (empty($bj_length)) {
            $bj_length = 6;
        }

        //num
        $last_id = $this->Baojia->query("select max(id) as last_id from baojias");
        $last_id = current($last_id);
        $last_id = $last_id[0]['last_id'];
        $last_id = intval($last_id);
        $last_id++;

        $num_len = strlen($last_id);
        $zero = '';
        for ($i = $num_len; $i <= $bj_length; $i++) {
            $zero .= "0";
        }
        $bianhao = $bj_abbre . $zero . $last_id;
        $this->set('bianhao', $bianhao);

        //details
        $details = $this->Baojia->query("select * from details where company_id=$company_id");
        $this->set('details', $details);
        $detail_arr = array();
        $first_detail = array();
        $index = 0;
        foreach ($details as $detail) {
            if ($index == 0) {
                $first_detail = $detail['details'];
            }
            $detail_arr[] = $detail['details'];
            $index++;
        }
        $this->set('detail_json', json_encode($detail_arr));
        $this->set('first_detail', $first_detail);

        //projects
        $projects = $this->Baojia->query("select * from projects where company_id=$company_id");
        $projects = json_encode($projects);
        $this->set('projects', $projects);

        //category
        $categories = $this->Baojia->query("select * from categories where company_id=$company_id");
        $this->set('categories', $categories);

        if ($this->request->is('post')) {
            $this->Baojia->create();
            $data = $this->request->data;

            //save details
            $details_tmp = $this->Baojia->query("select * from baojia_detail_tmp where parent_id='" . $data['baojia_id'] . "'");
            foreach ($details_tmp as $item) {
                $tmp = $item['baojia_detail_tmp'];
                $this->Baojia->query("insert into baojia_detail(detail_name,brand,type,size,unit_price,cost_price,total,count,unit,remark,project_id,project_name,category,parent_id,create_time,company_id)
        values('$tmp[detail_name]','$tmp[brand]','$tmp[type]','$tmp[size]','$tmp[unit_price]','$tmp[cost_price]','$tmp[total]',
        '$tmp[count]','$tmp[unit]','$tmp[remark]','$tmp[project_id]','$tmp[project_name]','$tmp[category]','$tmp[parent_id]','$tmp[create_time]',$company_id)");
            }

            //delete
            $this->Baojia->query("delete from baojia_detail_tmp where parent_id='" . $data['baojia_id'] . "'");

            $message = '保存';
            if (isset($data['btn_submit_type='])) {
                $data['status'] = '2';
                $message = '提交';

                $users = $this->Baojia->query("select * from users where role_id=1 or role_id=2");
                foreach ($users as $user) {
                    if (!empty($user['users']['email'])) {
                        $this->send_email($user['users']['email'], $data['baojia_id']);
                    }
                }
            }

            if (isset($data['btn_save'])) {
                $data['status'] = '1';
                $message = '保存';
            }

            $user_info = $this->Session->read('user_info');
            $data['creator'] = $user_info['username'];
            $data['checkor'] = '';
            $data['create_time'] = time();
            $data['update_time'] = time();
            $data['note'] = '';
            if ($this->Baojia->save($data)) {
                echo "<script>alert('" . $message . "成功！');window.location.href='/baojias';</script>";
            }
        } else {
            $this->Baojia->query("delete from baojia_detail_tmp where parent_id='$bianhao'");
        }
    }

    function edit()
    {
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];
        $this->set('company_id', $company_id);

        $id = $this->request->query('id');
        $back = $this->request->query('back');
        $this->set('back', $back);
        $checkedit = $this->request->query('check');
        $this->set('check', $checkedit);

        //details
        $details = $this->Baojia->query("select * from details where company_id=$company_id");
        $this->set('details', $details);
        $detail_arr = array();
        $first_detail = array();
        $index = 0;
        foreach ($details as $detail) {
            if ($index == 0) {
                $first_detail = $detail['details'];
            }
            $detail_arr[] = $detail['details'];
            $index++;
        }
        $this->set('detail_json', json_encode($detail_arr));
        $this->set('first_detail', $first_detail);

        //projects
        $projects = $this->Baojia->query("select * from projects where company_id=$company_id");
        $this->set('projects', $projects);

        //category
        $categories = $this->Baojia->query("select * from categories where company_id=$company_id");
        $this->set('categories', $categories);

        if ($this->request->is('get')) {
            $data = $this->Baojia->query("select * from baojias where id=$id");
            $data = current($data);

            $this->Baojia->query("delete from baojia_detail_tmp where parent_id='" . $data['baojias']['baojia_id'] . "'");

            //save details to tmp table
            $details_tmp = $this->Baojia->query("select * from baojia_detail where parent_id='" . $data['baojias']['baojia_id'] . "'");
            foreach ($details_tmp as $item) {
                $tmp = $item['baojia_detail'];
                $this->Baojia->query("insert into baojia_detail_tmp(detail_name,brand,type,size,unit_price,cost_price,total,count,unit,remark,project_id,project_name,category,parent_id,create_time, company_id)
        values('$tmp[detail_name]','$tmp[brand]','$tmp[type]','$tmp[size]','$tmp[unit_price]','$tmp[cost_price]','$tmp[total]',
        '$tmp[count]','$tmp[unit]','$tmp[remark]','$tmp[project_id]','$tmp[project_name]','$tmp[category]','$tmp[parent_id]','$tmp[create_time]', $company_id)");
            }

            $baojia_details = $this->Baojia->query("select * from baojia_detail_tmp where parent_id='" . $data['baojias']['baojia_id'] . "'");

            $this->set('item', $data);
            $this->set('baojia_details', $baojia_details);
        } else {
            $data = $this->request->data;

            //delete
            $this->Baojia->query("delete from baojia_detail where parent_id='" . $data['baojia_id'] . "'");

            //save details
            $details_tmp = $this->Baojia->query("select * from baojia_detail_tmp where parent_id='" . $data['baojia_id'] . "'");
            foreach ($details_tmp as $item) {
                $tmp = $item['baojia_detail_tmp'];
                $this->Baojia->query("insert into baojia_detail(detail_name,brand,type,size,unit_price,cost_price,total,count,unit,remark,project_id,project_name,category,parent_id, create_time, company_id)
        values('$tmp[detail_name]','$tmp[brand]','$tmp[type]','$tmp[size]','$tmp[unit_price]','$tmp[cost_price]','$tmp[total]',
        '$tmp[count]','$tmp[unit]','$tmp[remark]','$tmp[project_id]','$tmp[project_name]','$tmp[category]','$tmp[parent_id]', '$tmp[create_time]', $company_id)");
            }

            //delete
            $this->Baojia->query("delete from baojia_detail_tmp where parent_id='" . $data['baojia_id'] . "'");

            //edit
            $message = '保存';
            $link = '/baojias';
            $isEdit = false;
            $isBack = false;
            if (isset($data['btn_submit'])) {
                $data['status'] = '2';
                $message = '提交';
                $isEdit = true;
            }

            if (isset($data['btn_save'])) {
                $data['status'] = '1';
                $message = '保存';
            }

            //back
            if ($data['back'] == '1') {
                $message = '提交';
                $link = '/baojias/check';
                $data['status'] = '3';
                $isBack = true;
            }

            //check
            if ($data['check'] == '1') {
                $message = '提交';
                $link = '/baojias/check';
                $data['status'] = '4';
            }


            if ($isEdit && !$isBack) {
                $users = $this->Baojia->query("select * from users where role_id=1 or role_id=2");
                foreach ($users as $user) {
                    if (!empty($user['users']['email'])) {
                        $this->send_email($user['users']['email'], $data['baojia_id']);
                    }
                }
            }

            if ($isEdit && $isBack) {
                $users = $this->Baojia->query("select * from users where username='$data[creator]' limit 1");
                $users = current($users);
                if (!empty($users['users']['email'])) {
                    $this->send_email($users['users']['email'], $data['baojia_id']);
                }
            }

            if ($this->Baojia->save($data)) {
                echo "<script>alert('" . $message . "成功！');window.location.href='$link';</script>";
            } else {
                echo "<script>alert('" . $message . "失败！');window.location.href='/baojias/edit?id=$id';</script>";
            }
        }
    }

    /**
     * 删除操作
     */
    function delete()
    {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        $tmp = $this->Baojia->query("select baojia_id from baojias where id=$id");
        $baojia_id = $tmp['baojias']['baojia_id'];

        if (!empty($id) && $this->Baojia->delete($id)) {

            //delete
            $this->Baojia->query("delete from baojia_detail where parent_id='$baojia_id'");
            $this->Baojia->query("delete from baojia_detail_tmp where parent_id='$baojia_id'");

            echo "<script>alert('删除成功！');window.location.href='/baojias';</script>";
        }
    }

    function checkExist()
    {
        $this->layout = 'ajax';

        $name = $this->request->query('name');
        $id = $this->request->query('id');
        $name = trim($name);
        $id = trim($id);
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];
        $data = $this->Baojia->query("select * from baojias where baojia_id!='$id' and name='$name' and company_id=$company_id");
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

    function addDetail()
    {
        $this->layout = 'ajax';

        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];

        $data = $this->request->data;
        $time = date("Y-m-d");
        $this->Baojia->query("insert into baojia_detail_tmp(detail_name,brand,type,size,unit_price,cost_price,total,count,unit,remark,project_id,project_name,category,parent_id,create_time, company_id)
        values('$data[detail_name]','$data[brand]','$data[type]','$data[size]','$data[unit_price]','$data[cost_price]','$data[total]','$data[count]','$data[unit]','$data[remark]','$data[project_id]','$data[project_name]','$data[category]','$data[parent_id]','$time', $company_id)");
        echo json_encode(array('result' => 'ok'));
        exit;
    }

    function deleteDetail()
    {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        $this->Baojia->query("delete from baojia_detail_tmp where id=$id");
        echo 'ok';
        exit;
    }

    function loadTable()
    {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        $data = $this->Baojia->query("select * from baojia_detail_tmp where parent_id='$id'");
        $result = array();
        foreach ($data as $item) {
            $result[] = $item['baojia_detail_tmp'];
        }
        echo json_encode(array('result' => 'ok', 'data' => $result));
        exit;
    }

    function getDetails()
    {
        $name = $this->request->query('name');
        $data = $this->Baojia->query("select * from details where category='$name'");
        $result = array();
        foreach ($data as $item) {
            $result[] = $item['details'];
        }
        echo json_encode(array('result' => 'ok', 'data' => $result));
        exit;
    }

    /**
     * 审核页面
     */
    function check()
    {
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];

        $list = $this->Baojia->query("select b.*,s.* from baojias b left join statuses s on b.status=s.id where b.status=2 and company_id=$company_id");
        $this->set('list', $list);
    }

    /**
     * 通过操作
     */
    function pass()
    {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        if (!empty($id)) {
            $this->Baojia->query("update baojias set status=4 where id=$id");
        }
        $this->redirect('/baojias/check');
    }

    /**
     * 撤回操作
     */
    function refund()
    {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        if (!empty($id)) {
            $this->Baojia->query("update baojias set status=1 where id=$id");
        }
        $this->redirect('/baojias');
    }

    /**
     * 搜索
     */
    function search()
    {
        $this->layout = 'ajax';
        $data = $this->request->data;
        $keyword = $data['keyword'];

        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];

        $data = $this->Baojia->query("select count(*) as count from baojias where company_id=$company_id and baojia_id like '%$keyword%' or name like '%$keyword%'");
        $data = current($data);
        if ($data[0]['count'] == '1') {
            $this->redirect('/baojias/index?keyword=' . $keyword);
        } else {
            $this->redirect('/baojias/index?keyword=' . $keyword);
        }
    }

    /**
     * 预览
     */
    function preview()
    {
        $id = $this->request->query('id');

        $data = $this->Baojia->query("select * from baojias where id=$id");
        $data = current($data);

        $this->set('item', $data);
    }

    function getDefails()
    {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        $data = $this->Baojia->query("select * from baojia_detail where parent_id='$id'");
        $result = array();
        foreach ($data as $item) {
            $result[] = $item['baojia_detail'];
        }
        echo json_encode(array('result' => 'ok', 'data' => $result));
        exit;
    }

    /**
     * 报表
     */
    function reports()
    {
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];

        $categories = $this->Baojia->query("select * from categories where company_id=$company_id");
        $this->set('categories', $categories);

        $beginDate = $this->request->query('begin');
        $endDate = $this->request->query('end');
        $category = $this->request->query('category');

        $this->set('search_begindate', $beginDate);
        $this->set('search_enddate', $endDate);
        $this->set('searchname', $category);

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $search_begindate = $data['begindate'];
            $search_enddate = $data['enddate'];
            $category = $data['search_category'];
            $condition = '';
            if ($search_begindate != '' && $search_enddate != '') {
                $condition .= "and bd.create_time >= '$search_begindate' and bd.create_time <= '$search_enddate'";
            }

            //category condition
            if (isset($category) && $category) {
                if ($category != 'all') {
                    $condition .= "and bd.category = '$category'";
                }
            }

            $pieData = '';
            $pie_data = $this->Baojia->query('select bd.detail_name,sum(bd.total) as alltotal, sum(bd.cost_price*bd.count) as costtotal from baojia_detail as bd left join baojias as b on bd.parent_id = b.baojia_id where b.status=4 ' . $condition . ' group by bd.detail_name');
            foreach ($pie_data as $item) {
                $tmp = $item['bd'];
                $tmp1 = $item[0];
                $pieData .= "{label: '$tmp[detail_name]',value:$tmp1[alltotal]},";
            }

            $results = $this->Baojia->query('select bd.detail_name,bd.create_time,sum(bd.total) as alltotal, sum(bd.cost_price*bd.count) as costtotal ,bd.category from baojia_detail as bd left join baojias as b on bd.parent_id = b.baojia_id where b.status=4 ' . $condition . ' group by bd.detail_name,bd.create_time order by bd.create_time');
            $chartData = '';
            $barData = '';
            $tmp_time = '';
            $detail_names = array();
            $index = 0;
            foreach ($results as $result) {
                $tmp = $result['bd'];
                $tmp1 = $result[0];
                if ($result['bd']['create_time'] != $tmp_time) {
                    $tmp_time = $tmp['create_time'];
                    if ($index != 0) {
                        $chartData = substr($chartData, 0, strlen($chartData) - 1);
                        $barData = substr($barData, 0, strlen($barData) - 1);

                        $chartData .= "}, ";
                        $barData .= "}, ";
                    }

                    $chartData .= "{period: '$tmp_time', '$tmp[detail_name]': $tmp1[alltotal], ";
                    $barData .= "{period: '$tmp_time', '$tmp[detail_name]': $tmp1[alltotal], ";
                } else {
                    $chartData .= "'$tmp[detail_name]': $tmp1[alltotal], ";
                    $barData .= "'$tmp[detail_name]': $tmp1[alltotal], ";
                }

                if (!in_array($tmp['detail_name'], $detail_names)) {
                    $detail_names[] = $result['bd']['detail_name'];
                }
                $index++;
            }
            if (!empty($chartData)) {
                $chartData = substr($chartData, 0, strlen($chartData) - 2);
                $barData = substr($barData, 0, strlen($barData) - 2);
                $chartData .= "}";
                $barData .= "}";
            }

            $ykeys = '';
            $labels = '';
            foreach ($detail_names as $detail) {
                $labels .= "'$detail',";
                $ykeys .= "'$detail',";
            }
            $labels = substr($labels, 0, strlen($labels) - 1);
            $ykeys = substr($ykeys, 0, strlen($ykeys) - 1);
            $this->set('search_begindate', $search_begindate);
            $this->set('search_enddate', $search_enddate);
            $this->set('searchname', $category);
            $this->set('results', $results);
            $this->set('chartData', $chartData);
            $this->set('barData', $barData);
            $this->set('pieData', $pieData);
            $this->set('labels', $labels);
            $this->set('ykeys', $ykeys);
        } else {
            $this->set('chartData', null);
            $this->set('barData', null);
            $this->set('pieData', null);
            $this->set('labels', null);
            $this->set('ykeys', null);
            $this->set('results', []);
        }

    }

    /**
     * 导出
     */
    function export()
    {
        $this->layout = 'ajax';
        $this->Session->started();

        //get baojia
        $id = $this->request->query('id');
        $tp = $this->request->query('tp');

        $data = $this->Baojia->query("select * from baojias where id=$id");
        $data = current($data);

        App::import('Lib', 'PHPExcel');
        // 创建一个处理对象实例
        $objExcel = new PHPExcel();

        // 创建文件格式写入对象实例, uncomment
        $objWriter = new PHPExcel_Writer_Excel5($objExcel);
        //设置文档基本属性
        $objProps = $objExcel->getProperties();
        $objProps->setCreator("Jean");
        $objProps->setLastModifiedBy("Jean");
        $objProps->setTitle("Office XLS Test Document");
        $objProps->setSubject("Office XLS Test Document, Demo");
        $objProps->setDescription("Test document, generated by PHPExcel.");
        $objProps->setKeywords("office excel PHPExcel");
        $objProps->setCategory("Test");

        if ($tp === '1') {
            $this->exportTp($objExcel, $data);
        } elseif ($tp === '2') {
            $this->exportTp2($objExcel, $data);
        } elseif ($tp === '3') {
            $this->exportTp3($objExcel, $data);
        }

        //输出文件
        $outputFileName = urlencode($data['baojias']['name']) . '_' . date('Y-m-dHis') . '.xls';
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="' . $outputFileName . '"');
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
        exit();
    }

    function exportTp($objExcel, $data)
    {
        $sheet = 0;
        $objActSheet = $objExcel->getActiveSheet();

        $objExcel->setActiveSheetIndex($sheet);
        $objExcel->getActiveSheet()->mergeCells('A1:K1');
        $objExcel->getActiveSheet()->mergeCells('B2:L2');
        $objExcel->getActiveSheet()->mergeCells('A3:L3');

        //设置单元格内容
        $objExcel->setActiveSheetIndex($sheet)
            ->setCellValue('A1', '项目预算')
            ->setCellValue('L1', '预算单编号')
            ->setCellValue('A2', '客户:')
            ->setCellValue('A3', '项目描述:')
            ->setCellValue('A4', '项目编号')
            ->setCellValue('B4', '项目名称')
            ->setCellValue('C4', '分类')
            ->setCellValue('D4', '明细')
            ->setCellValue('E4', '品牌')
            ->setCellValue('F4', '型号')
            ->setCellValue('G4', '规格')
            ->setCellValue('H4', '单价（元）')
            ->setCellValue('I4', '数量')
            ->setCellValue('J4', '单位')
            ->setCellValue('K4', '小计')
            ->setCellValue('L4', '备注');

        //设置align
        $objExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray(array('font' => array('bold' => true), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
        $objExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setSize(20);
        $objExcel->getActiveSheet()->getStyle('L1')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));
        $objExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);
        $objExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
        $objExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(40);
        $objExcel->getActiveSheet()->getStyle('A1:K3')->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));

        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                    'color' => array('argb' => 'FF000000'),          //设置border颜色
                ),
            ),
        );
        $objExcel->getActiveSheet()->getStyle('A4:L4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objExcel->getActiveSheet()->getStyle('A4:L4')->getFill()->getStartColor()->setARGB('FFDCDCDC');

        //设置宽度
        $objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);

        $i = 5;
        $sum = 0;
        $objStyle = $objActSheet->getStyle('A1:L1');
        $objStyle->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
        $objExcel->getActiveSheet()->setCellValueExplicit('A1', $data['baojias']['name'] . "预算", PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValueExplicit('L1', "预算单编号：" . $data['baojias']['baojia_id'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValueExplicit('B2', $data['baojias']['customer'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValueExplicit('A3', '项目描述:' . $data['baojias']['description'], PHPExcel_Cell_DataType::TYPE_STRING);

        $projects = $this->Baojia->query("select project_id, project_name from baojia_detail where parent_id='" . $data['baojias']['baojia_id'] . "' group by project_name order by project_id");
        foreach ($projects as $project) {
            $projectName = $project['baojia_detail']['project_name'];

            $objExcel->getActiveSheet()->setCellValueExplicit('A' . $i, $project['baojia_detail']['project_id'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objExcel->getActiveSheet()->setCellValueExplicit('B' . $i, $project['baojia_detail']['project_name'], PHPExcel_Cell_DataType::TYPE_STRING);
            $p = $i;
            $categories = $this->Baojia->query("select category from baojia_detail where parent_id='" . $data['baojias']['baojia_id'] . "' and project_name='" . $projectName . "' group by category");

            foreach ($categories as $category) {
                $categoryName = $category['baojia_detail']['category'];
                $objExcel->getActiveSheet()->setCellValueExplicit('C' . $i, $categoryName, PHPExcel_Cell_DataType::TYPE_STRING);
                $c = $i;
                $res = $this->Baojia->query("select * from baojia_detail where parent_id='" . $data['baojias']['baojia_id'] . "' and category='" . $categoryName . "'");

                foreach ($res as $row) {
                    $objExcel->getActiveSheet()->setCellValueExplicit('D' . $i, $row['baojia_detail']['detail_name'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objExcel->getActiveSheet()->setCellValueExplicit('E' . $i, $row['baojia_detail']['brand'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objExcel->getActiveSheet()->setCellValueExplicit('F' . $i, $row['baojia_detail']['type'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objExcel->getActiveSheet()->setCellValueExplicit('G' . $i, $row['baojia_detail']['size'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objExcel->getActiveSheet()->setCellValueExplicit('H' . $i, $row['baojia_detail']['unit_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objExcel->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                    $objExcel->getActiveSheet()->setCellValueExplicit('I' . $i, $row['baojia_detail']['count'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objExcel->getActiveSheet()->setCellValueExplicit('J' . $i, $row['baojia_detail']['unit'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objExcel->getActiveSheet()->setCellValueExplicit('K' . $i, $row['baojia_detail']['total'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objExcel->getActiveSheet()->getStyle('K' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                    $objExcel->getActiveSheet()->setCellValueExplicit('L' . $i, $row['baojia_detail']['remark'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objExcel->getActiveSheet()->getStyle('L' . $i)->getAlignment()->setWrapText(true);


                    $i++;
                    $sum = $sum + $row['baojia_detail']['total'];
                }
                $objExcel->getActiveSheet()->mergeCells("C$c:C" . ($i - 1));
            }
            $objExcel->getActiveSheet()->mergeCells("A$p:A" . ($i - 1));
            $objExcel->getActiveSheet()->mergeCells("B$p:B" . ($i - 1));
        }

        $objExcel->getActiveSheet()->mergeCells("A$i:C$i");
        $objExcel->getActiveSheet()->mergeCells("D$i:J$i");
        $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "安装调试费用", PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValue('D' . $i, $data['baojias']['setup_cost'] / 100);
        $objExcel->getActiveSheet()->getStyle('D' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
        $objExcel->getActiveSheet()->setCellValueExplicit('K' . $i, $sum * $data['baojias']['setup_cost'] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objExcel->getActiveSheet()->getStyle('K' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


        $i++;
        $objExcel->getActiveSheet()->mergeCells("A$i:C$i");
        $objExcel->getActiveSheet()->mergeCells("D$i:J$i");
        $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "税费", PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValue('D' . $i, $data['baojias']['tax'] / 100);
        $objExcel->getActiveSheet()->getStyle('D' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
        $objExcel->getActiveSheet()->setCellValueExplicit('K' . $i, $sum * $data['baojias']['tax'] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objExcel->getActiveSheet()->getStyle('K' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $i++;
        $objExcel->getActiveSheet()->mergeCells("A$i:C$i");
        $objExcel->getActiveSheet()->mergeCells("D$i:J$i");
        $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "差旅费", PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValue('D' . $i, $data['baojias']['tour_cost'] / 100);
        $objExcel->getActiveSheet()->getStyle('D' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
        $objExcel->getActiveSheet()->setCellValueExplicit('K' . $i, $sum * $data['baojias']['tour_cost'] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objExcel->getActiveSheet()->getStyle('K' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


        $i++;
        $objExcel->getActiveSheet()->mergeCells("A$i:C$i");
        $objExcel->getActiveSheet()->mergeCells("D$i:J$i");
        $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "总价", PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValueExplicit('K' . $i, $data['baojias']['total_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objExcel->getActiveSheet()->getStyle('K' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


        $objExcel->getActiveSheet()->getStyle('A4:L' . $i)->applyFromArray($styleThinBlackBorderOutline);
        $objExcel->getActiveSheet()->getStyle('L4')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));
        $objExcel->getActiveSheet()->getStyle('A4:K' . $i)->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));
    }

    function exportTp2($objExcel, $data)
    {

        $categories = $this->Baojia->query("select category from baojia_detail where parent_id='" . $data['baojias']['baojia_id'] . "' group by category");

        $sheet = 0;
        foreach ($categories as $category) {
            $categoryName = $category['baojia_detail']['category'];

            if ($sheet > 0) {
                $objExcel->createSheet();
            }

            $objExcel->setActiveSheetIndex($sheet);
            $objActSheet = $objExcel->getActiveSheet();

            $objExcel->getActiveSheet()->setTitle($categoryName);

            $objExcel->getActiveSheet()->mergeCells('A1:H2');
            $objExcel->getActiveSheet()->mergeCells('B3:D3');
            $objExcel->getActiveSheet()->mergeCells('F3:H3');
            $objExcel->getActiveSheet()->mergeCells('A4:A5');
            $objExcel->getActiveSheet()->mergeCells('B4:B5');
            $objExcel->getActiveSheet()->mergeCells('C4:C5');
            $objExcel->getActiveSheet()->mergeCells('D4:D5');
            $objExcel->getActiveSheet()->mergeCells('E4:E5');
            $objExcel->getActiveSheet()->mergeCells('F4:F5');
            $objExcel->getActiveSheet()->mergeCells('G4:H4');


            //设置单元格内容
            $objExcel->setActiveSheetIndex($sheet)
                ->setCellValue('A1', '项目预算')
                ->setCellValue('A3', '工程名称:')
                ->setCellValue('E3', '标段:')
                ->setCellValue('A4', '序号')
                ->setCellValue('B4', '项目名称')
                ->setCellValue('C4', '明细')
                ->setCellValue('D4', '规格')
                ->setCellValue('E4', '计量单位')
                ->setCellValue('F4', '数量')
                ->setCellValue('G4', '金额（元）')
                ->setCellValue('G5', '单价')
                ->setCellValue('H5', '小计');

            $objActSheet->getStyle('A4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('B4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('C4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('D4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('E4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('F4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('G4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('H4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('A5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('B5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('C5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('E5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('F5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('G5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->getStyle('H5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


            //设置align
            $objExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(array('font' => array('bold' => true), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
            $objExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(20);
            $objExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);
            $objExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
            $objExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(40);
            $objExcel->getActiveSheet()->getStyle('A1:H3')->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));

            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                    ),
                ),
            );
            $objExcel->getActiveSheet()->getStyle('A4:H4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            //设置宽度
            $objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $objExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
            $objExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $objExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $objExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);


            $i = 6;
            $sum = 0;
            $objStyle = $objActSheet->getStyle('A3:H3');
            $objStyle->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objStyle = $objActSheet->getStyle('A5:H5');
            $objStyle->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objExcel->getActiveSheet()->setCellValueExplicit('A1', "分部分项工程量清单与计价表", PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('B3', $data['baojias']['name'], PHPExcel_Cell_DataType::TYPE_STRING);

            $projects = $this->Baojia->query("select project_id, project_name from baojia_detail where parent_id='" . $data['baojias']['baojia_id'] . "' group by project_name order by project_id");
            foreach ($projects as $project) {
                $projectName = $project['baojia_detail']['project_name'];

                $objExcel->getActiveSheet()->setCellValueExplicit('A' . $i, $project['baojia_detail']['project_id'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objExcel->getActiveSheet()->setCellValueExplicit('B' . $i, $project['baojia_detail']['project_name'], PHPExcel_Cell_DataType::TYPE_STRING);
                $p = $i;
                $res = $this->Baojia->query("select * from baojia_detail where parent_id='" . $data['baojias']['baojia_id'] . "' and category='" . $categoryName . "'");

                foreach ($res as $row) {
                    $objExcel->getActiveSheet()->setCellValueExplicit('C' . $i, $row['baojia_detail']['detail_name'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objExcel->getActiveSheet()->setCellValueExplicit('D' . $i, $row['baojia_detail']['size'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objExcel->getActiveSheet()->setCellValueExplicit('E' . $i, $row['baojia_detail']['unit'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objExcel->getActiveSheet()->setCellValueExplicit('F' . $i, $row['baojia_detail']['count'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objExcel->getActiveSheet()->setCellValueExplicit('G' . $i, $row['baojia_detail']['unit_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objExcel->getActiveSheet()->setCellValueExplicit('H' . $i, $row['baojia_detail']['total'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objExcel->getActiveSheet()->getStyle('G' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                    $objExcel->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


                    $i++;
                    $sum = $sum + $row['baojia_detail']['total'];
                }

                $objExcel->getActiveSheet()->mergeCells("A$p:A" . ($i - 1));
                $objExcel->getActiveSheet()->mergeCells("B$p:B" . ($i - 1));
            }

            $total = $sum;
            $objExcel->getActiveSheet()->mergeCells("A$i:B$i");
            $objExcel->getActiveSheet()->mergeCells("C$i:G$i");
            $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "安装调试费用", PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValue('C' . $i, $data['baojias']['setup_cost'] / 100);
            $objExcel->getActiveSheet()->getStyle('C' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
            $objExcel->getActiveSheet()->setCellValue('H' . $i, $sum * $data['baojias']['setup_cost'] / 100);
            $objExcel->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $total = $total + ($sum * $data['baojias']['setup_cost'] / 100);

            $i++;
            $objExcel->getActiveSheet()->mergeCells("A$i:B$i");
            $objExcel->getActiveSheet()->mergeCells("C$i:G$i");
            $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "税费", PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValue('C' . $i, $data['baojias']['tax'] / 100);
            $objExcel->getActiveSheet()->getStyle('C' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
            $objExcel->getActiveSheet()->setCellValue('H' . $i, $sum * $data['baojias']['tax'] / 100);
            $objExcel->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $total = $total + ($sum * $data['baojias']['tax'] / 100);


            $i++;
            $objExcel->getActiveSheet()->mergeCells("A$i:B$i");
            $objExcel->getActiveSheet()->mergeCells("C$i:G$i");
            $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "差旅费", PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValue('C' . $i, $data['baojias']['tour_cost'] / 100);
            $objExcel->getActiveSheet()->getStyle('C' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
            $objExcel->getActiveSheet()->setCellValue('H' . $i, $sum * $data['baojias']['tour_cost'] / 100);
            $objExcel->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $total = $total + ($sum * $data['baojias']['tour_cost'] / 100);


            $i++;
            $objExcel->getActiveSheet()->mergeCells("A$i:G$i");
            $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "合计", PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('H' . $i, $total, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objExcel->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


            $objExcel->getActiveSheet()->getStyle('A4:H' . $i)->applyFromArray($styleThinBlackBorderOutline);
            $objExcel->getActiveSheet()->getStyle('A4:H' . $i)->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));

            $sheet++;
        }
    }

    function exportTp3($objExcel, $data)
    {
        $projects = $this->Baojia->query("select project_name from baojia_detail where parent_id='" . $data['baojias']['baojia_id'] . "' group by project_name order by project_id");

        $i = 3;
        $sheet = 0;
        $sum = 0;

        $objExcel->setActiveSheetIndex($sheet);
        $objActSheet = $objExcel->getActiveSheet();
        $objExcel->getActiveSheet()->mergeCells('A1:G1');

        //设置单元格内容
        $objExcel->setActiveSheetIndex($sheet)
            ->setCellValue('A1', '项目预算')
            ->setCellValue('A2', '项目名称')
            ->setCellValue('B2', '规格')
            ->setCellValue('C2', '数量')
            ->setCellValue('D2', '单位')
            ->setCellValue('E2', '单价')
            ->setCellValue('F2', '合价')
            ->setCellValue('G2', '主材材料说明');

        //设置align
        $objExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(array('font' => array('bold' => true), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
        $objExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(20);
        $objExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);
        $objExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
        $objExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));

        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                    'color' => array('argb' => 'FF000000'),          //设置border颜色
                ),
            ),
        );

        //设置宽度
        $objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $objExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);

        $objStyle = $objActSheet->getStyle('A1:G1');
        $objStyle->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
        $objExcel->getActiveSheet()->setCellValueExplicit('A1', $data['baojias']['name'] . "工程概算清单", PHPExcel_Cell_DataType::TYPE_STRING);

        foreach ($projects as $project) {

            $projectName = $project['baojia_detail']['project_name'];

            $res = $this->Baojia->query("select * from baojia_detail where parent_id='" . $data['baojias']['baojia_id'] . "' and project_name='" . $projectName . "'");

            $objExcel->getActiveSheet()->mergeCells("A$i:G$i");
            $objExcel->getActiveSheet()->setCellValueExplicit('A' . $i, $projectName, PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->getStyle("A$i:G$i")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objExcel->getActiveSheet()->getStyle("A$i:G$i")->getFill()->getStartColor()->setARGB('FFDCDCDC');
            $i++;

            foreach ($res as $row) {
                $objExcel->getActiveSheet()->setCellValueExplicit('A' . $i, $row['baojia_detail']['detail_name'], PHPExcel_Cell_DataType::TYPE_STRING);
                $objExcel->getActiveSheet()->setCellValueExplicit('B' . $i, $row['baojia_detail']['size'], PHPExcel_Cell_DataType::TYPE_STRING);
                $objExcel->getActiveSheet()->setCellValueExplicit('C' . $i, $row['baojia_detail']['count'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objExcel->getActiveSheet()->setCellValueExplicit('D' . $i, $row['baojia_detail']['unit'], PHPExcel_Cell_DataType::TYPE_STRING);
                $objExcel->getActiveSheet()->setCellValueExplicit('E' . $i, $row['baojia_detail']['unit_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objExcel->getActiveSheet()->setCellValueExplicit('F' . $i, $row['baojia_detail']['total'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objExcel->getActiveSheet()->setCellValueExplicit('G' . $i, $row['baojia_detail']['remark'], PHPExcel_Cell_DataType::TYPE_STRING);
                $objExcel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->setWrapText(true);
                $objExcel->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objExcel->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $i++;
                $sum = $sum + $row['baojia_detail']['total'];
            }
        }

        $objExcel->getActiveSheet()->getStyle("A$i:G$i")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

        $objExcel->getActiveSheet()->mergeCells("B$i:E$i");
        $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "安装调试费用", PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValue('B' . $i, $data['baojias']['setup_cost'] / 100);
        $objExcel->getActiveSheet()->getStyle('B' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);

        $objExcel->getActiveSheet()->setCellValueExplicit('F' . $i, $sum * $data['baojias']['setup_cost'] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objExcel->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


        $i++;
        $objExcel->getActiveSheet()->mergeCells("B$i:E$i");
        $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "税费", PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValue('B' . $i, $data['baojias']['tax'] / 100);
        $objExcel->getActiveSheet()->getStyle('B' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
        $objExcel->getActiveSheet()->setCellValueExplicit('F' . $i, $sum * $data['baojias']['tax'] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objExcel->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        $i++;
        $objExcel->getActiveSheet()->mergeCells("B$i:E$i");
        $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "差旅费", PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValue('B' . $i, $data['baojias']['tour_cost'] / 100);
        $objExcel->getActiveSheet()->getStyle('B' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
        $objExcel->getActiveSheet()->setCellValueExplicit('F' . $i, $sum * $data['baojias']['tour_cost'] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objExcel->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


        $i++;
        $objExcel->getActiveSheet()->setCellValueExplicit("A$i", "总价", PHPExcel_Cell_DataType::TYPE_STRING);
        $objExcel->getActiveSheet()->setCellValueExplicit('F' . $i, $data['baojias']['total_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objExcel->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


        $objExcel->getActiveSheet()->getStyle('A3:G' . $i)->applyFromArray($styleThinBlackBorderOutline);
        $objExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));
        $objExcel->getActiveSheet()->getStyle('A3:F' . $i)->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));

    }

}


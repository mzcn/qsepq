<?php
App::uses('AppController', 'Controller');

class DetailsController extends AppController {
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

        $category = 'all';
        $data = $this->request->data;
        $is_export = array_key_exists('btn_export', $data);

        if(!empty($data)) {
            $category = $data['search_category'];
        }

        if($category == 'all') {
            $sql = "select * from details where company_id=$company_id";
        } else {
            $sql = "select * from details where category='$category' and company_id=$company_id";
        }

        $list = $this->Detail->query($sql);
        $this->set('list', $list);

        $categories = $this->Detail->query("select * from categories where company_id=$company_id");
        $this->set('categories', $categories);

        $this->set('searchname', $category);

        if($is_export) {
            $this->export($category, $list);
        }
    }

    function add() {
        $userInfo = $this->Session->read('user_info');
        $this->set('company_id', $userInfo['company_id']);

        //category
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];
        $categories = $this->Detail->query("select * from categories where company_id=$company_id");
        $this->set('categories', $categories);

        $company_info = $this->Session->read('company_info');
        $mx_abbre = $company_info['mx_index'];
        $mx_length = $company_info['mx_length'];
        if(empty($mx_length)) {
            $mx_length = 6;
        }

        $last_id = $this->Detail->query("select max(id) as last_id from details");
        $last_id = current($last_id);
        $last_id = $last_id[0]['last_id'];
        $last_id = intval($last_id);
        $last_id++;

        $num_len = strlen($last_id);
        $zero = '';
        for($i = $num_len; $i <= $mx_length; $i++){
            $zero .= "0";
        }
        $bianhao = $mx_abbre.$zero.$last_id;
        $this->set('bianhao',$bianhao);

        if ($this->request->is('post')) {
            $this->Detail->create();
            if ($this->Detail->save($this->request->data)) {
                echo "<script>alert('保存成功！');window.location.href='/details';</script>";
            }
        }
    }

    function edit() {
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];

        //category
        $categories = $this->Detail->query("select * from categories where company_id=$company_id");
        $this->set('categories', $categories);

        $id = $this->request->query('id');

        if ($this->request->is('get')) {
            $data = $this->Detail->query("select * from details where id=$id");
            $this->set('item', current($data));
        } else {
            if ($this->Detail->save($this->request->data)) {
                echo "<script>alert('编辑成功！');window.location.href='/details';</script>";
            } else {
                echo "<script>alert('编辑失败！');window.location.href='/details/edit?id=$id';</script>";
            }
        }
    }

    function delete() {
        $this->layout = 'ajax';
        $id = $this->request->query('id');
        if (!empty($id) && $this->Detail->delete($id)) {
            echo "<script>alert('删除成功！');window.location.href='/details';</script>";
        }
    }

    function checkExist() {
        $this->layout = 'ajax';

        $name = $this->request->query('name');
        $id = $this->request->query('id');
        $userInfo = $this->Session->read('user_info');
        $company_id = $userInfo['company_id'];

        $name = trim($name);
        $id = trim($id);
        if(empty($id)) {
            $sql = "select * from details where name='$name' and company_id=$company_id";
        } else {
            $sql = "select * from details where id!=$id and name='$name' and company_id=$company_id";
        }
        $data = $this->Detail->query($sql);
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

    function export($category, $data) {
        $this->layout = 'ajax';

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

        //输出文件
        if($category == 'all') {
            $category = '所有分类';
        }

        $this->exportTp($objExcel, $category, $data);

        $outputFileName = $category ."的明细列表_".date('Y-m-dHis').'.xls';
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outputFileName.'"');
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
        exit();
    }

    function exportTp($objExcel, $category, $data) {
        $sheet = 0;
        $objActSheet = $objExcel->getActiveSheet();

        $objExcel->setActiveSheetIndex($sheet);
        $objExcel->getActiveSheet()->mergeCells('A1:I1');

        //设置单元格内容
        $objExcel->setActiveSheetIndex($sheet)
            ->setCellValue('A1',$category.'的明细列表')
            ->setCellValue('A2','编号')
            ->setCellValue('B2','名称')
            ->setCellValue('C2','分类')
            ->setCellValue('D2','品牌')
            ->setCellValue('E2','规格')
            ->setCellValue('F2','型号')
            ->setCellValue('G2','单价')
            ->setCellValue('H2','原价')
            ->setCellValue('I2','单位');

        //设置align
        $objExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray(array('font' => array ('bold' => true),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
        $objExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(20);
        $objExcel->getActiveSheet()->getStyle('L1')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));
        $objExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);
        $objExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
        $objExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(40);

        $objExcel->getActiveSheet()->getStyle('A2:I2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objExcel->getActiveSheet()->getStyle('A2:I2')->getFill()->getStartColor()->setARGB('FFDCDCDC');

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


        $i=3;
        $objStyle = $objActSheet->getStyle('A1:I1');
        $objStyle->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
        foreach ($data as $row) {
            $objExcel->getActiveSheet()->setCellValueExplicit('A'.$i, $row['details']['detail_id'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('B'.$i, $row['details']['name'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('C'.$i, $row['details']['category'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('D'.$i, $row['details']['brand'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('E'.$i, $row['details']['size'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('F'.$i, $row['details']['type'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('G'.$i, $row['details']['unit_price'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('H'.$i, $row['details']['cost_price'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->setCellValueExplicit('I'.$i, $row['details']['unit'], PHPExcel_Cell_DataType::TYPE_STRING);

            $i++;
        }
    }

} 

<?php
/**
 * Created by PhpStorm.
 * User: rational
 * Date: 15-8-29
 * Time: 上午12:36
 */

App::uses('AppModel', 'Model');

class BaojiaDetail extends AppModel {
    public $name = 'BaojiaDetail';

    public $databaseType = 'mysql';
    public $useDbConfig = 'yipuqu';
    public $useTable = 'baojia_detail';
    public $primaryKey  = 'id';

//    public $mongoSchema = [
//        'id'         => ['type' => 'int', 'length' => 11],
//        'parent _id'   => ['type' => 'int', 'length' => 100],
//        'name'  => ['type' => 'varchar', 'length' => 100],
//        'category_id'  => ['type' => 'int', 'length' => 11],
//        'detail_id'      => ['type' => 'varchar',  'length' => 100],
//        'detail' => ['type' => 'varchar',  'length' => 100],
//        'brand'     => ['type' => 'varchar',  'length' => 10],
//        'type'     => ['type' => 'varchar',  'length' => 10],
//        'unit_price'     => ['type' => 'varchar',  'length' => 10],
//        'count'     => ['type' => 'int',  'length' => 10],
//        'total_price'     => ['type' => 'varchar',  'length' => 20],
//        'remark'     => ['type' => 'varchar',  'length' => 255]
//    ];
} 
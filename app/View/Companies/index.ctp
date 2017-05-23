<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">公司管理</h1>
                    <div class="form-group col-md-12 text-right">
                        <a href="/companies/add" class="btn btn-primary btn-sm right">新建公司</a>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            公司列表
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-company">
                                    <thead>
                                        <tr>
                                            <th>序号</th>
                                            <th>公司名称</th>
                                            <th>登录是否默认</th>
                                            <th>报价前缀</th>
                                            <th>明细前缀</th>
                                            <th>报价编号长度</th>
                                            <th>明细编号长度</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 1;
                                        foreach($list as $item) {?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $index++;?></td>
                                            <td><?php echo $item['companies']['company_name'];?></td>
                                            <td><?php echo $item['companies']['is_default'] == '1' ? '是':'否';?></td>
                                            <td><?php echo $item['companies']['baojia_abbre'];?></td>
                                            <td><?php echo $item['companies']['mingxi_abbre'];?></td>
                                            <td><?php echo $item['companies']['baojia_length'];?></td>
                                            <td><?php echo $item['companies']['mingxi_length'];?></td>
                                            <td>
                                            <a href="/companies/edit?id=<?php echo $item['companies']['id'];?>" class="btn btn-outline btn-primary btn-sm">修改</a>
                                            <a href="/companies/delete?id=<?php echo $item['companies']['id'];?>" onclick="if(!confirm('确定删除该条记录吗？')) return false;" class="btn btn-outline btn-danger btn-sm">删除</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

        <!-- /#page-wrapper -->

        <script src="../js/company.js"></script>
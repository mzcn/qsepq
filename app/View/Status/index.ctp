<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">状态管理</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            状态列表
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>状态名称</th>
                                            <th>允许编辑</th>
                                            <th>允许删除</th>
                                            <th>允许导出</th>
                                            <th>允许撤回</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($list as $item) {?>
                                        <tr class="even gradeC">
                                            <td><?php echo $item['statuses']['status_name'];?></td>
                                            <td><?php echo $item['statuses']['is_edit'] == '1' ? '是' : '否';?></td>
                                            <td><?php echo $item['statuses']['is_delete'] == '1' ? '是' : '否';?></td>
                                            <td><?php echo $item['statuses']['is_export'] == '1' ? '是' : '否';?></td>
                                            <td><?php echo $item['statuses']['is_refund'] == '1' ? '是' : '否';?></td>
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
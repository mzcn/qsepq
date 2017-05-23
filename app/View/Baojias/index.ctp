<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">报价管理</h1>

            <div class="form-group col-md-12 text-right">
                <a href="/baojias/add" class="btn btn-primary btn-sm right">新建报价单</a>
            </div>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    报价单列表
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-baojias">
                            <thead>
                            <tr>
                                <th>编号</th>
                                <th>项目名称</th>
                                <!--<th>项目描述</th>-->
                                <th>客户名称</th>
                                <th>总价</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($list as $item) {?>
                            <tr class="odd gradeX" id="<?php echo $item['b']['id']; ?>">
                                <td>
                                    <a href="baojias/preview?id=<?php echo $item['b']['id'];?>"><?php echo $item['b']['baojia_id'];?></a>
                                </td>
                                <td><?php echo $item['b']['name'];?></td>
                                <!--<td><?php echo $item['b']['description'];?></td>-->
                                <td class="center"><?php echo $item['b']['customer'];?></td>
                                <td class="center">¥<?php echo $item['b']['total_price'];?></td>
                                <td><?php echo $item['s']['status_name'];?></td>
                                <td>
                                    <div style="display: <?php echo (($item['s']['is_edit'] == '1') ? 'inline':'none'); ?>">
                                        <a href="/baojias/edit?id=<?php echo $item['b']['id']; ?>"
                                           class="btn btn-outline btn-primary btn-sm">修改</a></div>
                                    <div style="display: <?php echo (($item['s']['is_delete'] == '1') ? 'inline':'none'); ?>">
                                        <a href="#"
                                           onclick="removeBaojia(<?php echo $item['b']['id']; ?>)"
                                           class="btn btn-outline btn-danger btn-sm">删除</a></div>
                                    <div style="display: <?php echo (($item['s']['is_refund'] == '1') ? 'inline':'none'); ?>">
                                        <a href="/baojias/refund?id=<?php echo $item['b']['id']; ?>"
                                           onclick="if(!confirm('确定撤回该条记录吗？')) return false;"
                                           class="btn btn-outline btn-warning btn-sm">撤回</a></div>
                                    <div style="display: <?php echo (($item['s']['is_export'] == '1') ? 'inline':'none'); ?>">
                                        <a href="#" onclick="exportExcel(<?php echo $item['b']['id']; ?>);"
                                           class="btn btn-outline btn-success btn-sm">导出</a></div>
                                    <a href="baojias/preview?id=<?php echo $item['b']['id'];?>"
                                       class="btn btn-outline btn-info btn-sm">预览</a>
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
</div>
<!-- /#page-wrapper -->
<script src="../js/baojias.js"></script>
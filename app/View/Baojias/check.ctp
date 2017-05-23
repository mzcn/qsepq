<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">审核管理</h1>
                </div>
                <!-- /.col-lg-12 -->
          </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            待审核报价单列表
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
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($list as $item) {?>
                                        <tr class="odd gradeX">
                                            <td><a href="/baojias/preview?id=<?php echo $item['b']['id'];?>"><?php echo $item['b']['baojia_id'];?></a></td>
                                            <td><?php echo $item['b']['name'];?></td>
                                            <!--<td><?php echo $item['b']['description'];?></td>-->
                                            <td class="center"><?php echo $item['b']['customer'];?></td>
                                            <td class="center">¥<?php echo $item['b']['total_price'];?></td>
                                            <td>
                                            <a href="/baojias/pass?id=<?php echo $item['b']['id']; ?>" onclick="if(!confirm('确定通过吗？')) return false;"  class="btn btn-outline btn-success btn-sm">通过</a>
                                            <a href="/baojias/edit?id=<?php echo $item['b']['id']; ?>&check=1" class="btn btn-outline btn-primary btn-sm">修改</a>
                                            <a href="/baojias/edit?id=<?php echo $item['b']['id']; ?>&back=1" class="btn btn-outline btn-danger btn-sm">退回</a>
                                            <a href="/baojias/preview?id=<?php echo $item['b']['id'];?>" class="btn btn-outline btn-success btn-sm">预览</a>
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
        <script src="../js/baojias.js"></script>
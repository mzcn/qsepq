<div id="page-wrapper">
            <div class="row">
                  <div class="col-lg-12">
                    <h1 class="page-header">欢迎使用<?php echo $company_info['name']?>报价系统</h1>
                  </div>
                  <!-- /.col-lg-12 -->
                </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-heading"> <i class="fa fa-bell fa-fw"></i> 最新报价 </div>
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
                                        <tr class="odd gradeX">
                                            <td><a href="/baojias/preview?id=<?php echo $item['b']['id'];?>"><?php echo $item['b']['baojia_id'];?></a></td>
                                            <td><?php echo $item['b']['name'];?></td>
                                            <!--<td><?php echo $item['b']['description'];?></td>-->
                                            <td class="center"><?php echo $item['b']['customer'];?></td>
                                            <td class="center">¥<?php echo $item['b']['total_price'];?></td>
                                            <td><?php echo $item['s']['status_name'];?></td>
                                            <td>
                                                <a href="#" onclick="exportExcel(<?php echo $item['b']['id']; ?>);" class="btn btn-outline btn-success btn-sm">导出</a>
                                            <a href="/baojias/preview?id=<?php echo $item['b']['id'];?>" class="btn btn-outline btn-info btn-sm">预览</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            <a href="/baojias" class="btn btn-default btn-block">查看所有报价</a> </div>
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
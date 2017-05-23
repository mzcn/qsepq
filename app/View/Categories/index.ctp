<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">信息管理</h1>
                    <div class="form-group col-md-12 text-right">
                        <a href="/categories/add" class="btn btn-primary btn-sm right">新建信息</a>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            信息列表
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-category">
                                    <thead>
                                        <tr>
                                            <th>序号</th>
                                            <th>名称</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 1;
                                        foreach($list as $item) {?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $index++;?></td>
                                            <td><?php echo $item['categories']['name'];?></td>
                                            <td>
                                            <a href="/categories/edit?id=<?php echo $item['categories']['id'];?>" class="btn btn-outline btn-primary btn-sm">修改</a>
                                            <a href="/categories/delete?id=<?php echo $item['categories']['id'];?>" onclick="if(!confirm('确定删除该条记录吗？')) return false;" class="btn btn-outline btn-danger btn-sm">删除</a>
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
        <script src="../js/category.js"></script>
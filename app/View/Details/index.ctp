<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">明细管理</h1>
            <form action="/details" method="POST">
                <div class="form-group col-md-10">
                    <div class="col-md-4">
                        <div class="col-md-4">
                            <label for="search_category">明细分类：</label></div>
                        <div class="col-md-8">
                            <select name="search_category" id="search_category" class="form-control">
                                <option value="all"
                                <?php if($searchname == 'all') echo 'selected'; ?>>全部</option>
                                <?php
                              foreach($categories as $item) {
                                  ?>
                                <option value="<?php echo $item['categories']['name'];?>"
                                <?php if($searchname == $item['categories']['name']) echo 'selected'; ?>
                                ><?php echo $item['categories']['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button id="btn_submit" name="btn_submit" type="submit" class="btn btn-default">查询</button>
                        <button id="btn_export" name="btn_export" type="submit" class="btn btn-default">导出</button>
                    </div>
                </div>
            </form>
            <div class="form-group col-md-2 text-right">
                <a href="/details/add" class="btn btn-primary btn-sm right">新建明细</a>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    明细列表
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-detail">
                            <thead>
                            <tr>
                                <th>编号</th>
                                <th>名称</th>
                                <th>分类</th>
                                <th>品牌</th>
                                <th>规格</th>
                                <th>类型</th>
                                <th>单价</th>
                                <th>原价</th>
                                <th>单位</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($list as $item) {?>
                            <tr class="odd gradeX">
                                <td><?php echo $item['details']['detail_id'];?></td>
                                <td><?php echo $item['details']['name'];?></td>
                                <td><?php echo $item['details']['category'];?></td>
                                <td><?php echo $item['details']['brand'];?></td>
                                <td><?php echo $item['details']['size'];?></td>
                                <td><?php echo $item['details']['type'];?></td>
                                <td><?php echo $item['details']['unit_price'];?></td>
                                <td><?php echo $item['details']['cost_price'];?></td>
                                <td><?php echo $item['details']['unit'];?></td>
                                <td>
                                    <a href="/details/edit?id=<?php echo $item['details']['id'];?>"
                                       class="btn btn-outline btn-primary btn-sm">修改</a>
                                    <a href="/details/delete?id=<?php echo $item['details']['id'];?>"
                                       onclick="if(!confirm('确定删除该条记录吗？')) return false;"
                                       class="btn btn-outline btn-danger btn-sm">删除</a>
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
    <script src="../js/details.js"></script>

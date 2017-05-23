<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">报表中心</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div>
        <form action="/baojias/reports" method="POST">
            <div class="form-group  col-md-10">
                <div class="col-md-3">
                    <div class="col-md-4">
                        <label for="begindate">开始日期:</label>
                    </div>
                    <div class="col-md-8"><input type="text" id="begindate" name="begindate" class="form-control"
                                                 value="<?php echo $search_begindate;?>" data-date="2013-01-02"
                                                 data-date-format="yyyy-mm-dd" class="datepicker span11" readonly></div>
                </div>
                <div class="col-md-3">
                    <div class="col-md-4">
                        <label for="enddate">结束日期:</label>
                    </div>
                    <div class="col-md-8"><input type="text" id="enddate" name="enddate"
                                                 value="<?php echo $search_enddate;?>" class="form-control"
                                                 data-date="2013-01-02" data-date-format="yyyy-mm-dd"
                                                 class="datepicker span11" readonly></div>
                </div>
                <div class="col-md-3">
                    <div class="col-md-4">
                        <label for="search_category">分类:</label>
                    </div>
                    <div class="col-md-8"><select name="search_category" id="search_category" class="form-control">
                        <option value="all"
                        <?php if($searchname == 'all') echo 'selected'; ?>>全部</option>
                        <?php
                              foreach($categories as $item) {
                                  ?>
                        <option value="<?php echo $item['categories']['name'];?>"
                        <?php if($searchname == $item['categories']['name']) echo 'selected'; ?>
                        ><?php echo $item['categories']['name']; ?></option>
                        <?php } ?>
                    </select></div>
                </div>
                <div class="col-md-3">
                    <button id="btn_submit" name="btn_submit" type="submit" class="btn btn-default">查询</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-bar-chart-o fa-fw"></i> 柱状图
                    <div class="pull-right">

                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>时间</th>
                                        <th>分类</th>
                                        <th>明细</th>
                                        <th>总价</th>
                                        <th>原价</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($results as $item) { ?>
                                    <tr>
                                        <td><?php echo $item['bd']['create_time']; ?></td>
                                        <td><?php echo $item['bd']['category']; ?></td>
                                        <td><?php echo $item['bd']['detail_name']; ?></td>
                                        <td><?php echo $item[0]['alltotal']; ?></td>
                                        <td><?php echo $item[0]['costtotal']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.col-lg-4 (nested) -->
                        <div class="col-lg-6">
                            <div id="morris-bar-chart"></div>
                        </div>
                        <!-- /.col-lg-8 (nested) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <!-- /.panel -->
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-bar-chart-o fa-fw"></i> 饼状图</div>
                <div class="panel-body">
                    <div id="morris-donut-chart"></div>
                    <a href="#" onclick="alert('抱歉，此功能暂未开发！');" class="btn btn-default btn-block">View Details</a></div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-bar-chart-o fa-fw"></i> 曲线图
                    <div class="pull-right">

                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-area-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script>
    $(document).ready(function () {
        $('#begindate').datepicker({
            dateFormat: 'yy-mm-dd ',
            changeMonth: true,
            changeYear: true
        });

        $('#enddate').datepicker({
            dateFormat: 'yy-mm-dd ',
            changeMonth: true,
            changeYear: true
        });

        $('#reset').click(function () {
            $('#begindate').val('');
            $('#enddate').val('');

            $('#search_name').val('');
            $('#s2id_search_name span').html('全部');
        });

        $('#export').click(function () {
            window.location.href = "export.php";
        });

        $('#btn_submit').click(function () {
            if ($.trim($('#begindate').val()) == '' || $.trim($('#enddate').val()) == '') {
                alert('请选择日期!');
                return false;
            }
        });
    });
</script>

<script>
    $(function () {
        Morris.Area({
            element: 'morris-area-chart',
            data: [ <?php echo $chartData;?> ],
            xkey: 'period',
            ykeys:[ <?php echo $ykeys;?>],
            labels: [ <?php echo $labels;?>],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });

        Morris.Donut({
            element: 'morris-donut-chart',
            data: [ <?php echo $pieData;?>],
            resize: true
        });

        Morris.Bar({
            element: 'morris-bar-chart',
            data: [ <?php echo $barData;?>],
            xkey: 'period',
            ykeys:[ <?php echo $ykeys;?>],
            labels: [ <?php echo $labels;?>],
            hideHover: 'auto',
            resize: true
        });
    });

</script>
<div id="page-wrapper">
    <!--startprint-->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">报价单</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    报价单编号：<?php echo $item['baojias']['baojia_id'];?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row form-group">
                                <div class="col-lg-1">
                                    <label>总项目名称:</label>
                                </div>
                                <div class="col-lg-11">
                                    <?php echo $item['baojias']['name'];?>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-1">
                                    <label>客户名称:</label>
                                </div>
                                <div class="col-lg-11">
                                    <?php echo $item['baojias']['customer'];?>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-1">
                                    <label>总项目描述:</label>
                                </div>
                                <div class="col-lg-11"><?php echo $item['baojias']['description'];?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            项目明细
                                        </div>
                                        <div class="panel-body">
                                            <div class="dataTable_wrapper">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>编号</th>
                                                        <th>项目名称</th>
                                                        <th>分类</th>
                                                        <th>明细编号</th>
                                                        <th>明细</th>
                                                        <th>品牌</th>
                                                        <th>型号</th>
                                                        <th>单价（元）</th>
                                                        <th>数量</th>
                                                        <th>单位</th>
                                                        <th>小计（元）</th>
                                                        <th class='col-md-3'>备注</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="detail_body" name="detail_body">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">

                                <div class="col-lg-1">
                                    <label>税收:</label>
                                </div>
                                <div class="col-lg-11">
                                    <?php echo $item['baojias']['tax'];?>%
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-1">
                                    <label>安装调试费用:</label>
                                </div>
                                <div class="col-lg-11">
                                    <?php echo $item['baojias']['setup_cost'];?>%
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-1">
                                    <label>差旅费:</label>
                                </div>
                                <div class="col-lg-11">
                                    <?php echo $item['baojias']['tour_cost'];?>%
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-1">
                                    <label>总计:</label>
                                </div>
                                <div class="col-lg-11">
                                    ¥<?php echo $item['baojias']['total_price'];?>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!--endprint-->
    <!-- /#page-wrapper -->
    <div class="form-group text-center">
        <div style="display: <?php echo (($item["baojias"]['status'] == '4') ? 'inline':'none'); ?>">
        <button onclick="exportExcel(<?php echo $item["baojias"]["id"];?>)" type="button"
                class="btn btn-default">导出
        </button>
        </div>
        <button type="button" class="btn btn-default" onClick="document.execCommand('print')">打印</button>

    </div>
</div>
<script src="../js/baojias.js"></script>
<script>
    getDetailsForPreview("<?=$item['baojias']['baojia_id']?>");
</script>
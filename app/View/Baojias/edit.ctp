<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">编辑报价单</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    预算基本信息
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="baojia_form" name="baojia_form" method="post" action="/baojias/edit" role="form">
                                <?php if($back == '1') { ?>
                                <div class="form-group">
                                    <label>退回原因</label>
                                    <textarea id="note" name="note" class="form-control" rows="3"></textarea>
                                </div>
                                <?php }
                                        if($item['baojias']['note'] != '') {?>
                                <div class="form-group">
                                    <label>退回原因：<?php echo $item['baojias']['note'];?>.</label>
                                </div>
                                <?php } ?>

                                <div class="form-group">
                                    <label>总项目编号</label>
                                    <input id="baojia_id" name="baojia_id" maxlength="20" class="form-control"
                                           value="<?php echo $item['baojias']['baojia_id']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>总项目名称</label>
                                    <input id="name" name="name" maxlength="100" class="form-control"
                                           value="<?php echo $item['baojias']['name']; ?>">
                                    <font color="red" style="margin-left:5px;">*</font><span id="name_error"></span>
                                </div>
                                <div class="form-group">
                                    <label>客户名称</label>
                                    <input id="customer" name="customer" maxlength="100" class="form-control"
                                           value="<?php echo $item['baojias']['customer']; ?>">
                                    <font color="red" style="margin-left:5px;">*</font><span id="customer_error"></span>
                                </div>
                                <div class="form-group">
                                    <label>总项目描述</label>
                                    <textarea id="description" name="description" class="form-control"
                                              rows="3"><?php echo $item['baojias']['description']; ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            项目明细
                                            <!-- Button trigger modal -->
                                            <div class="pull-right" style="margin-top: -5px;">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                        data-toggle="modal"
                                                        data-target="#myModal"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal" tabindex="-1"
                                                 role="dialog" aria-labelledby="myModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                    data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                添加项目明细</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div id="errorMsg" class="alert alert-danger alert-dismissable" style="display: none">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="project_name">项目名称</label>
                                                                    <select class="form-control"
                                                                            id="project_name"
                                                                            name="project_name">
                                                                        <option value="">---请选择---
                                                                        </option>
                                                                        <?php foreach($projects as $project) { ?>
                                                                        <option value="<?php echo $project['projects']['id']?>"><?php echo $project['projects']['name']?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="category">分类</label>
                                                                    <select class="form-control"
                                                                            id="category"
                                                                            name="category">
                                                                        <option value="">---请选择---
                                                                        </option>
                                                                        <?php foreach($categories as $category) { ?>
                                                                        <option value="<?php echo $category['categories']['id']?>"><?php echo $category['categories']['name']?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="detail">明细</label>
                                                                    <select class="form-control"
                                                                            id="detail" name="detail">
                                                                        <option value="">---请选择---
                                                                        </option>
                                                                        <?php foreach($details as $detail) { ?>
                                                                        <option value="<?php echo $detail['details']['id']?>"><?php echo $detail['details']['name']?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="brand">品牌</label>
                                                                    <input id="brand" name="brand"
                                                                           value="<?php isset($first_detail['brand']) ? $first_detail['brand']:'' ?>"
                                                                           class="form-control"
                                                                           placeholder="-" readonly>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="type">型号</label>
                                                                    <input id="type" name="type"
                                                                           value="<?php isset($first_detail['type']) ? $first_detail['type']:'' ?>"
                                                                           class="form-control"
                                                                           placeholder="-" readonly>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="size">规格</label>
                                                                    <input id="size" name="size"
                                                                           value="<?php isset($first_detail['size']) ? $first_detail['size']:'' ?>"
                                                                           class="form-control"
                                                                           placeholder="-" readonly>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="count">数量</label>
                                                                    <input id="count" name="count"
                                                                           class="form-control"
                                                                           value="1">
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="unit_price">单价</label>
                                                                    <input id="unit_price"
                                                                           name="unit_price"
                                                                           value="<?php isset($first_detail['unit_price']) ? $first_detail['unit_price']:'' ?>"
                                                                           class="form-control"
                                                                           readonly>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="unit">单位</label>
                                                                    <input id="unit" name="unit"
                                                                           value="<?php isset($first_detail['unit']) ? $first_detail['unit']:'' ?>"
                                                                           class="form-control"
                                                                           readonly>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="total">小记</label>
                                                                    <input id="total" name="total"
                                                                           class="form-control"
                                                                           value="<?php isset($first_detail['total']) ? $first_detail['total']:'' ?>"
                                                                           readonly>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="remark">备注</label><textarea
                                                                        id="remark" name="remark"
                                                                        class="form-control" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button id="btn_cancel_detail" type="button"
                                                                    class="btn btn-default"
                                                                    data-dismiss="modal">取消
                                                            </button>
                                                            <button id="btn_add_detail"
                                                                    name="btn_add_detail" type="button"
                                                                    class="btn btn-primary">保存
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->

                                            <div id="details_list" name="details_list" class="dataTable_wrapper">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>编号</th>
                                                        <th>项目名称</th>
                                                        <th>分类</th>
                                                        <th>明细</th>
                                                        <th>品牌</th>
                                                        <th>型号</th>
                                                        <th>规格</th>
                                                        <th>单价（元）</th>
                                                        <th>数量</th>
                                                        <th>单位</th>
                                                        <th>小计（元）</th>
                                                        <th class='col-md-3'>备注</th>
                                                        <th>删除</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="detail_body" name="detail_body">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>税收</label>
                                    <input id="tax" name="tax" class="form-control" placeholder="6%"
                                           value="<?php echo $item['baojias']['tax']; ?>"
                                           onkeypress="return event.keyCode>=48&&event.keyCode<=57||event.keyCode==46"
                                           onpaste="return !clipboardData.getData('text').match(/\D/)"
                                           ondragenter="return false"
                                           style="ime-mode:Disabled"/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>差旅费</label>
                                    <input id="tour_cost" name="tour_cost" class="form-control" placeholder="10%"
                                           value="<?php echo $item['baojias']['tour_cost']; ?>"
                                           onkeypress="return event.keyCode>=48&&event.keyCode<=57||event.keyCode==46"
                                           onpaste="return !clipboardData.getData('text').match(/\D/)"
                                           ondragenter="return false"
                                           style="ime-mode:Disabled"/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>安装调试费用</label>
                                    <input id="setup_cost" name="setup_cost" class="form-control" placeholder="10%"
                                           value="<?php echo $item['baojias']['setup_cost']; ?>"
                                           onkeypress="return event.keyCode>=48&&event.keyCode<=57||event.keyCode==46"
                                           onpaste="return !clipboardData.getData('text').match(/\D/)"
                                           ondragenter="return false"
                                           style="ime-mode:Disabled"/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>总价</label>
                                    <input id="total_price" name="total_price" class="form-control" readonly
                                           value="<?php echo $item['baojias']['total_price']; ?>">
                                </div>

                                <input id="creator" name="creator" type="hidden"
                                       value="<?php echo $item['baojias']['creator']; ?>">
                                <input id="id" name="id" type="hidden"
                                       value="<?php echo $item['baojias']['id']; ?>">
                                <input id="back" name="back" type="hidden" value="<?php echo $back; ?>">
                                <input id="check" name="check" type="hidden" value="<?php echo $check; ?>">

<input type="hidden" id="company_id" name="company_id" value="<?php echo $item['baojias']['company_id'];?>" />
                                <div class="form-group text-center">
                                    <?php if ($check != '1' && $back != '1') { ?>
                                    <button id="btn_save" name="btn_save" type="submit" class="btn btn-default">保存
                                    </button>
                                    <?php } ?>
                                    <button id="btn_submit" name="btn_submit" type="submit" class="btn btn-default">提交</button>
                                    <button type="reset" id="btn_reset" name="btn_reset" class="btn btn-default">重置
                                    </button>
                                </div>
                            </form>
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
</div>
    <!-- /#page-wrapper -->
<script>
    var details = '<?php echo $detail_json; ?>';
</script>

<script src="../js/baojias.js"></script>
<script>
    loadTable('<?=$item['baojias']['baojia_id']?>');
</script>
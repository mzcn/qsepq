       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">编辑明细</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            明细
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="detail_form" name="detail_form" method="post" action="/details/edit">
                                        <div class="form-group">
                                            <label>编号</label>
                                            <input id="detail_id" name="detail_id" maxlength="20" class="form-control" readonly value="<?php echo $item['details']['detail_id']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>名称</label>
                                            <input id="name" name="name" maxlength="100" class="form-control" value="<?php echo $item['details']['name']?>">
                                            <font color="red" style="margin-left:5px;">*</font><span id="name_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>分类</label>
                                            <select class="form-control" id="category" name="category">
                                                <?php foreach($categories as $category) { ?>
                                                <option value="<?php echo $category['categories']['name']?>" <?php if ($category['categories']['name']===$item['details']['category']) echo'selected=true' ?>><?php echo $category['categories']['name'];?></option>
                                                <?php } ?>
                                            </select>
                                            <font color="red" style="margin-left:5px;">*</font><span id="category_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>品牌</label>
                                            <input id="brand" name="brand" maxlength="100" class="form-control" value="<?php echo $item['details']['brand']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>规格</label>
                                            <input id="size" name="size" maxlength="255" class="form-control" value="<?php echo $item['details']['size']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>型号</label>
                                            <input id="type" name="type" maxlength="100" class="form-control" value="<?php echo $item['details']['type']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>单价(元）</label>
                                            <input id="unit_price" name="unit_price" maxlength="20" class="form-control" value="<?php echo $item['details']['unit_price']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>原价(元）</label>
                                            <input id="cost_price" name="cost_price" maxlength="20" class="form-control" value="<?php echo $item['details']['cost_price']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>单位</label>
                                            <input id="unit" name="unit" maxlength="20" class="form-control" value="<?php echo $item['details']['unit'];?>">
                                        </div>

                                        <input type="hidden" id="id" name="id" value="<?php echo $item['details']['id'];?>" />
                                        <input type="hidden" id="company_id" name="company_id" value="<?php echo $item['details']['company_id'];?>" />
                                        <div class="form-group text-center">
                                        <button type="submit" id="btn_save" name="btn_save" class="btn btn-default">保存</button>
                                        <button type="reset" id="btn_reset" name="btn_reset" class="btn btn-default">重置</button>
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
        <!-- /#page-wrapper -->
        <script src="../js/details.js"></script>

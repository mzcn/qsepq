       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">编辑公司</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            公司
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="company_form" name="company_form" method="post" action="/companies/edit">
                                        <div class="form-group">
                                            <label>公司名称</label>
                                            <input id="company_name" name="company_name" maxlength="100" class="form-control" value="<?php echo $item['companies']['company_name'] ?>">
                                            <font color="red" style="margin-left:5px;">*</font><span id="company_name_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>登录是否默认</label>
                                            <input id="radio_yes" name="is_default" type="radio" value="1" <?php if($item['companies']['is_default'] == '1') echo 'checked';?>><label for="radio_yes">是</label>&nbsp;&nbsp;
                                            <input id="radio_no" name="is_default" type="radio" value="0" <?php if($item['companies']['is_default'] != '1') echo 'checked';?>><label for="radio_no">否</label>
                                        </div>
                                        <div class="form-group">
                                            <label>报价前缀</label>
                                            <input id="baojia_abbre" name="baojia_abbre" maxlength="10" class="form-control" value="<?php echo $item['companies']['baojia_abbre'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>报价编号长度（不含前缀）</label>
                                            <input id="baojia_length" name="baojia_length" maxlength="10" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php echo $item['companies']['baojia_length'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>明细前缀</label>
                                            <input id="mingxi_abbre" name="mingxi_abbre" maxlength="11" class="form-control" value="<?php echo $item['companies']['mingxi_abbre'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>明细编号长度（不含前缀）</label>
                                            <input id="mingxi_length" name="mingxi_length" maxlength="11" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php echo $item['companies']['mingxi_length'] ?>">
                                        </div>

                                        <input type="hidden" id="id" name="id" value="<?php echo $item['companies']['id'];?>" />

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
        <script src="../js/getFirstChar.js"></script>
        <script src="../js/company.js"></script>
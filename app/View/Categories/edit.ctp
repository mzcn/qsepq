       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">编辑分类</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            分类
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="category_form" name="category_form" method="post" action="/categories/edit">
                                        <div class="form-group">
                                            <label>分类名称</label>
                                            <input id="name" name="name" maxlength="100" class="form-control" value="<?php echo $item['categories']['name'];?>">
                                             <font color="red" style="margin-left:5px;">*</font><span id="name_error"></span>
                                        </div>

                                        <input type="hidden" id="company_id" name="company_id" value="<?php echo $item['categories']['company_id'];?>" />
                                        <input type="hidden" id="id" name="id" value="<?php echo $item['categories']['id'];?>" />
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
        <script src="../js/category.js"></script>
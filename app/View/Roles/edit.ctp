       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">编辑角色</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            角色
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="role_form" name="role_form" method="post" action="/roles/edit">
                                        <div class="form-group">
                                            <label>角色名称</label>
                                            <input id="role_name" name="role_name" maxlength="100" class="form-control" value="<?php echo $role['role_name']?>">
                                            <font color="red" style="margin-left:5px;">*</font><span id="name_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>描述</label>
                                            <input id="remark" name="remark" maxlength="255" class="form-control" value="<?php echo $role['remark']?>">
                                        </div>
					                    <?php foreach($list as $item) { ?>
                                        <div class="form-group">
                                            <input type="checkbox" id="<?php echo $item['menus']['menu_id'];?>"
                                            name="<?php echo $item['menus']['menu_id'];?>" maxlength="10"
                                            <?php if (in_array($item['menus']['menu_id'], $role['rights'])) echo 'checked';?>>
                                            <label for="<?php echo $item['menus']['menu_id'];?>"><?php echo $item['menus']['menu_name'];?></label>
                                        </div>
					                    <?php } ?>

                                        <input type="hidden" id="role_id" name="role_id" value="<?php echo $role['role_id']?>" />
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
        <script src="../js/role.js"></script>

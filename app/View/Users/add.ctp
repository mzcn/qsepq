       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">新建用户</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            用户
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="user_form" name="user_form" method="post" action="/users/add">
                                        <div class="form-group">
                                            <label>用户名</label>
                                            <input id="username" name="username" maxlength="100" class="form-control">
                                            <font color="red" style="margin-left:5px;">*</font><span id="name_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>密码</label>
                                            <input type="password" id="password" name="password" maxlength="20" class="form-control">
                                            <font color="red" style="margin-left:5px;">*</font><span id="userpass_error"></span>
                                        </div>
					<div class="form-group">
                                            <label>确认密码</label>
                                            <input type="password" id="confirm_password" name="confirm_password" maxlength="20" class="form-control">
                                            <font color="red" style="margin-left:5px;">*</font><span id="confirmpass_error"></span>
                                        </div>
					<div class="form-group">
                                            <label>Email</label>
                                            <input id="email" name="email" maxlength="64" class="form-control">
                                            <font color="red" style="margin-left:5px;">*</font><span id="email_error"></span>
                                        </div>
					<div class="form-group">
                                            <label>电话</label>
                                            <input id="telephone" name="telephone" maxlength="12" class="form-control">
                                        </div>
　　　　　　　　　　　　　　　　　　　　<div class="form-group">
                                            <label>角色</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <select id="role_id" name="role_id">
						<?php foreach($roles as $item) { ?>
                                                <option id="<?php echo $item['roles']['role_id'];?>" value="<?php echo $item['roles']['role_id'];?>"><?php echo $item['roles']['role_name'];?></option>
                                                <?php } ?>
					    </select>
                                        </div>

                                        <div class="form-group">
                                            <label>所属公司</label>
                                            <?php foreach($companies as $company) { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" id="<?php echo 'company_'.$company['companies']['id'];?>" name="<?php echo 'company_'.$company['companies']['id'];?>">
                                            <label for="<?php echo 'company_'.$company['companies']['id'];?>"><?php echo $company['companies']['company_name'];?></label>
                                            <?php } ?>
                                        </div>

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
        <script src="../js/users.js"></script>

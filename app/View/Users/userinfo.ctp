       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">用户信息</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            用户: <?php echo $userinfo['users']['username'];?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="user_form" name="user_form" method="post" action="/users/userinfo">
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
                                            <label>电子邮件（当前电子邮件为：<?php echo $userinfo['users']['email']; ?>）</label>
                                            <input id="email" name="email" maxlength="64" class="form-control" value="">
                                            <font color="red" style="margin-left:5px;">*</font><span id="email_error"></span>
                                        </div>
					<div class="form-group">
                                            <label>电话（当前电话为：<?php echo $userinfo['users']['telephone']; ?>）</label>
                                            <input id="telephone" name="telephone" maxlength="12" class="form-control" value="">
                                        </div>

                                        <div class="form-group text-center">
                                        <button type="submit" id="btn_save" name="btn_save" class="btn btn-default">更新</button>
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
        <script src="../js/userinfo.js"></script>

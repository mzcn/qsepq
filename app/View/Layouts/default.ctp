<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $company_info['name'];?>报价系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css"
          rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/datepicker.css"/>

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Dialog Responsive CSS -->
    <link rel="stylesheet" href="../dist/css/bootstrap-dialog.min.css"/>

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- JQuery UI -->
    <link href="../bower_components/jquery-ui/themes/base/jquery-ui.min.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- JQuery UI -->
    <script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script src="../bower_components/jquery-ui/ui/autocomplete.js"></script>


    <script src="../js/common.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Dialog JavaScript -->
    <script src="../dist/js/bootstrap-dialog.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <script src="../js/bootstrap-datepicker.js"></script>


    <!-- Morris Charts JavaScript -->
    <script src="../bower_components/raphael/raphael-min.js"></script>
    <script src="../bower_components/morrisjs/morris.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</head>

<body>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span
                    class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                    class="icon-bar"></span> <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="index.html"><?php echo $company_info['name'];?>报价系统</a></div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <label>欢迎, <i><?php echo $user_info['username'];?></i></label>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>

                <ul class="dropdown-menu dropdown-user">
                    <li><a href="/users/userinfo"><i class="fa fa-user fa-fw"></i> 用户信息</a></li>
                    <li class="divider"></li>
                    <li><a href="/users/logout"><i class="fa fa-sign-out fa-fw"></i> 退出</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <form id="search_form" name="search_form" action="/baojias/search" method="post">
                            <div class="input-group custom-search-form">
                                <input type="text" id="keyword" name="keyword" value="<?php echo $keyword;?>"
                                       class="form-control" placeholder="编号或项目名称...">
              <span class="input-group-btn">
              <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
              </span></div>
                        </form>
                        <!-- /input-group -->
                    </li>
                    <li><a href="/baojias/home"><i class="fa fa-dashboard fa-fw"></i> 系统首页</a></li>

                    <?php if ($user_info['role_id'] == '1' || $user_info['role_id'] == '3') { ?>
                    <li><a href="/baojias"><i class="fa fa-files-o fa-fw"></i> 报价管理</a></li>
                    <?php  }?>

                    <?php if ($user_info['role_id'] == '1') { ?>
                    <li><a href="/baojias/check"><i class="fa fa-edit fa-fw"></i> 审核管理</a></li>
                    <?php  }?>

                    <?php if ($user_info['role_id'] == '1') { ?>
                    <li><a href="/baojias/reports"><i class="fa fa-bar-chart-o fa-fw"></i> 报表中心</a></li>
                    <?php  }?>

                    <?php if ($user_info['role_id'] == '1') { ?>
                    <li><a href="/details"><i class="fa fa-table fa-fw"></i> 明细管理</a></li>
                    <?php  }?>

                    <?php if ($user_info['role_id'] == '1' || $user_info['role_id'] == '2') { ?>
                    <li><a href="#"><i class="fa fa-wrench fa-fw"></i> 系统设置<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="/status"> 状态管理</a></li>
                            <li><a href="/categories"> 分类管理</a></li>
                            <li><a href="/companies"> 公司管理</a></li>
                            <li><a href="/projects"> 项目管理</a></li>
                            <li><a href="/roles"> 权限管理</a></li>
                            <!--<li><a href="/templates"> 导出模板管理</a></li>-->
                            <li><a href="/users/list"> 用户管理</a></li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <?php  }?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
    <div id="content">

        <?php echo $this->Session->flash(); ?>

        <?php echo $this->fetch('content'); ?>
    </div>


</div>
<!-- /#wrapper -->


</body>
</html>

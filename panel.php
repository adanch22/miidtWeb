<?php
/**
 * Created by PhpStorm.
 * User: azulyoro
 * Date: 11/04/16
 * Time: 6:11 PM
 */

session_start();
if(!isset($_SESSION['admin_name'])) {
    header("location:register/login.php");
}

error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__ . '/adminpanel.php';
$demo = new panel();
$user = $demo->getUser($_SESSION['admin_name']);
$admin_id = $user["admin_id"];
$is_teacher = $user["is_teacher"];
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="icon" href="logo.png">
    <title>CIEX Admin: <?= $_SESSION['admin_name']?></title>


    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/grid.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

</head>
<body class="body">
<!--ICON CIEX --------------------------------------------------------------------------------------------------------->
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 logo">
                <img src="logo.png" alt="Norway" class="img-circle center-block">
            </div>
            <div class="col-md-12 admin">
                <h1 class="text-center blink">
                    Admin Panel Ciex
                </h1>
            </div>
        </div>
    </div>
</header>
<!--Contents --------------------------------------------------------------------------------------------------------->
<div class="container-fluid">
    <div class="row">
        <!--coursesContent ---------------------------------------------------------------------------------------------->
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" id="coursesContent" >
            <div class="panel-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Courses
                    </div>
                    <div class="panel-body " id="scrCourse" style=" margin-right: 2px;  max-height:50%;  overflow-y: scroll;">
                        <ul id="courses" class="coursecontent">
                            <!--courses here-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--MessageContent -------------------------------------------------------------------------------------------->
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" id="messageContent"  >
            <div class="text-right box">
                <!--showMessages--------------------------------------------------------------------------------------->
                <div class="msg_container" id="scrollMsj">
                    <ul id="messages">
                        <!--messages here-->
                    </ul>
                </div>
                <div class="send_container">
                    <!--inputMessages---------------------------------------------------------------------------------->
                    <textarea placeholder="Type a message here" class="form-control" id="message"></textarea>
                    <!--sendButton and image loader-------------------------------------------------------------------->
                    <div class="butimg">
                        <form enctype="multipart/form-data" class="formulario">
                            <button type="button" class="btn btn-success" id="send">
                                <i class="fa fa-send-o"></i>Go!</button>
                            <span class="btn  botton btn-file">
                                <span id="loadImage">Image&nbsp;<i class="fa fa-camera"></i></span>
                                <input name="archivo" type="file" id="imagen"/>
                            </span>
                            <div style="padding-left: 40%; padding-right: 40%"><img src="loader.gif" id="loader"/></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--OptionsContent -------------------------------------------------------------------------------------------->
        <div class="col-lg-4 col-md-4 " id="optionsContent" >
            <div class="panel-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">Options</div>
                    <div class="panel-body" id="options">
                        <!--options here-->
                        <button type="button" id="optionAddStudent" class="btn btn-success btn-block disabled" data-toggle="modal" >
                            <i class="fa fa-user-plus"></i>&nbsp;Add new student</button>
                        <div class="line"></div>
                        <button type="button" id="optionEditStudent" class="btn btn-success btn-block" data-toggle="modal" data-target=".editStudent">
                            <i class="fa fa-users"></i>&nbsp;Edit student</button>
                        <div class="line"></div>
                        <div id="onlyAdmin">
                            <button type="button" id="optionAddTeacher" class="btn btn-info btn-block" data-toggle="modal" data-target=".addTeacher">
                                <i class="fa fa-user-plus"></i>&nbsp;Add new teacher</button>
                            <div class="line"></div>
                            <button type="button" id="optionEditTeacher" class="btn btn-info btn-block" data-toggle="modal" data-target=".editTeacher">
                                <i class="fa fa-users"></i>&nbsp;Edit teacher</button>
                            <div class="line"></div>
                        </div>
                        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target=".addCourse">
                            <i class="fa fa-plus"></i>&nbsp;Add New Course</button>
                        <div class="line"></div>
                        <button type="button" id="remove" class="btn btn-success btn-block disabled" data-toggle="modal">
                            <i class="fa fa-minus"></i>&nbsp;Delete/Clean Course</button>
                        <div class="line"></div>
                        <button type="button" id="closeSession" class="btn btn-danger btn-block">close session&nbsp;<i class="fa fa-sign-out"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__. '/modals/students.php';
if(!$is_teacher){
    require_once __DIR__ . '/modals/teachers.php';
}
require_once __DIR__ . '/modals/course.php';
?>
<!-- Need for the connection sql-->
<script type="text/javascript" src="js/conection.js" ></script>
<!--check login-->
<script type="text/javascript">
    var admin_id = '<?= $admin_id ?>';
</script>
</body>
</html>
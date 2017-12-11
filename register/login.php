<?php
/**
 * Created by PhpStorm.
 * User: azulyoro
 * Date: 11/04/16
 * Time: 6:11 PM
 */
session_start();
if(isset($_SESSION['admin_name'])) {
    header("location:../index.php");
}
?>

<?php
require_once __DIR__ . '/../adminpanel.php';
$panel = new panel();
$name="";
?>
<!Doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="icon" href="../logo.png">
    <title>MIIDT:LOGIN</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/signin.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../js/jquery-2.2.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>


<div id="loginBody" class="modal-sm center-block" style=" margin-top:50px; height: 200px; width: 400px" role="document">
    <div class="modal-content">
        <div class="modal-header" align="center">
            <img src="logo.png" class="img-responsive">
            <h3 class="modal-title" id="gridSystemModalLabel">OBJETOS DE APRENDIZAJE </h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <form method="post" action="../v1/admin/login">
                        <div class="form-group">
                            <label for="inputAdminName">Administrador</label>
                            <input type="text" class="form-control" name="admin_name"  placeholder="Type Admin Name">
                            <br>
                            <label for="inputAdminPassword">Contraseña</label>
                            <input type="password" class="form-control" name="password"
                                   placeholder="Type Password">
                        </div>

                        <div class="modal-footer">
                            <!--                            <button type="button" id="downloadApp" class="btn btn-info">Descargar App</button>-->
                            <a target="_blank" href="/../miidt/downloadApp.php">Descargar la App</a>
                            <input type="submit" id="loginButton_" class="btn btn-primary" value="Ingresar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
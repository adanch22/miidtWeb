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
require_once __DIR__ . '/../include/header.php';
require_once __DIR__ . '/../adminpanel.php';
$panel = new panel();
$name="";
?>
<head>

</head>
<html>
<body>
    <div id="loginBody" class="modal-sm center-block" style=" margin-top:100px; height: 200px; width: 400px" role="document">
        <div class="modal-content">
            <!--configs------------------------------------------------------------------------------------------------>
            <div class="modal-header">
                <h4 class="modal-title" id="gridSystemModalLabel">Ciex Login</h4>
            </div>
            <!--inputs------------------------------------------------------------------------------------------------->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <form method="post" action="../v1/admin/login">
                            <div class="form-group">
                                <label for="inputAdminName">Admin</label>
                                <input type="text" class="form-control" name="admin_name"  placeholder="Type Admin Name">
                                <br>
                                <label for="inputAdminPassword">Password</label>
                                <input type="password" class="form-control" name="password"
                                       placeholder="Type Password">
                            </div>
                            <!--Buttons------------------------------------------------------------------------------------>
                            <div class="modal-footer">
                                <button type="button" id="downloadApp" class="btn btn-info">Download App</button>
                                <input type="submit" id="loginButton_" class="btn btn-primary" value="Log in">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</body>
</html>
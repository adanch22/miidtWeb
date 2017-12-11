<?php
/**
 * Created by PhpStorm.
 * User: azulyoro
 * Date: 11/04/16
 * Time: 6:11 PM
 */

session_start();
if(!isset($_SESSION['admin_name'])) {
    header("location:/ciex/register/login.php");
}

error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__ . '/../adminpanel.php';
$demo = new panel();
$user = $demo->getUser($_SESSION['admin_name']);
$admin_id = $user["admin_id"];
$is_teacher = $user["is_teacher"];
?>


<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Objetos de Aprendizaje</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
    <link href="css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
    <script src="js/fileinput.min.js" type="text/javascript"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

</head>

<body>

<?php include 'inc/header.php'; ?>


<div id="main-content" class="container">
    <div id="home-tiles" class="row">


        <div class=" panel-body col-sm-12 col-md-12 col-lg-3 hidden-xs hidden-sm hidden-md sidebar " id="optionsContent">
            <ul class="nav nav-sidebar">

            </ul>
            <ul class="nav nav-sidebar ">
                <li ><button type="button" id="home" class="btn btn-default btn-block">Inicio</button></li>
                <li ><button type="button" id="optionp0" class="btn btn-default btn-block ">Temáticas</button></li>
                <li ><button type="button" id="optionp1" class="btn btn-block btn-default">Objetos de aprendizaje </button></li>
                <li ><button type="button" id="optionp2" class="btn btn-block btn-default">Ejercicios Y Actividades</button></li>
                <li><button type="button" id="optionreturn" class="btn btn-success btn-block">Regresar a principal*</button></li>

                <img src="img/ic_launcher-web.png" class="img-responsive center-block" width="200" height="200">

            </ul>
            <ul class="nav nav-sidebar">

            </ul>
        </div>


        <div class="col-lg-9 col-md-12 col-xs-12 main" id="workspaceContent" data-spy="scroll" data-offset="50">

            <div class="panel-group">
                <div id="panelworkspace" class="panel-body">

                    <div class="panel-body">

                        <!-- area para objetos de aprendizaje -->
                        <div class="col-lg-12 col-md-12 col-xs-12" id="oaHome">

                            <div class="row">
                                <div class="col-lg-12">
                                    <h1 class="page-header">
                                        Bienvenidos <small>(Vista para el docente)</small>
                                    </h1>
                                    <!-- <ol class="breadcrumb">
                                         <li class="active">
                                             <i class="fa fa-dashboard"></i>
                                         </li>
                                     </ol>-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-info alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <i class="fa fa-info-circle"></i>  <strong>Importante</strong> Antes de iniciar con los temas revisa los documentos y tutoriales.
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="panel panel-blue">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-comments fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-right">
                                                        <div class="huge">X</div>
                                                        <div>Documentos</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#">
                                                <div class="panel-heading">
                                                    <span class="pull-left">Detalles</span>
                                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="panel panel-green">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-right">
                                                        <div class="huge">X</div>
                                                        <div>Tutoriales</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#">
                                                <div class="panel-heading">
                                                    <span class="pull-left">Detalles</span>
                                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="panel panel-yellow">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-tasks fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-right">
                                                        <div class="huge">X</div>
                                                        <div>Documentos</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#">
                                                <div class="panel-heading">
                                                    <span class="pull-left">Detalles</span>
                                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.row -->


                                <!-- <div class="panel-group">
                                     <div id="paneloaHome" class="panel panel-body">
                                         <div class="panel-group ">
                                             <div class="panel-body " >
                                                 <img src="img/ic_launcher-web.png" class="img-responsive center-block" width="300" height="236">
                                             </div>
                                         </div>
                                     </div>
                                 </div>-->

                            </div>
                        </div>






                        <!-- area para administrar las tematicas -->
                        <div class="col-lg-12 col-md-12 col-xs-12" id="tematicaContent">

                            <div class="row" id="">
                                <div class="col-lg-12">
                                    <h1 class="page-header">
                                        Temáticas <small>(Panel)</small>
                                    </h1>
                                    <!-- <ol class="breadcrumb">
                                         <li class="active">
                                             <i class="fa fa-dashboard"></i>
                                         </li>
                                     </ol>-->
                                </div>
                            </div>


                            <div class="panel-group">
                                <div id="paneltematica" class="panel panel-body">
                                    <div class="panel-default " align="center" >
                                        <div id="remove-tematica" class="upload-msg"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->

                                    </div>
                                    <div class="panel-default " align="center" >
                                        <h5 class="backgroud btn-block">.</h5>
                                    </div>
                                    <div  class="panel-group ">

                                        <div class="panel-body">
                                            <button type="button" id="option0" class="col-lg-3 btn btn-primary" data-toggle="modal" data-target=".viewtematicas"><i class='glyphicon glyphicon-plus'></i> </button>
                                            <button type="button" id="optionr1" id_book="" name_book="" class="col-lg-1 btn btn-danger btn-md invisible" data-toggle="modal" data-target="#tematicaDelete"><i class='glyphicon glyphicon-trash'></i> </button>
                                            <button type="button" id="optione1" class="col-lg-1 btn btn-info btn-md invisible" data-toggle="modal" data-target="#"><i class='glyphicon glyphicon-edit'></i> </button>
                                            <h5 class="" id="pk_tema">?</h5>



                                        </div>
                                        <div class="panel-body " id="scrOA" style=" margin-right: 2px;  max-height:30%;  overflow-y: scroll;">
                                            <ul class="list-group " id="tematicas">
                                                <!--temáticas  here-->

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-default " align="center" >
                                        <h5 class="backgroud btn-block">.</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="alert alert-info alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="fa fa-info-circle"></i>  <strong>Nota</strong> En este apartado podras administrar las temáticas(Agregar, editar, eliminar).
                                </div>
                            </div>


                        </div>






                        <div class="col-lg-12 col-md-12 col-xs-12" id="oaContent">

                            <div class="row">
                                <div class="col-lg-12">
                                    <h1 class="page-header">
                                        Objetos de aprendizaje <small>(Panel)</small>
                                    </h1>
                                    <!-- <ol class="breadcrumb">
                                         <li class="active">
                                             <i class="fa fa-dashboard"></i>
                                         </li>
                                     </ol>-->
                                </div>
                            </div>



                            <div class="panel-group">
                                <div id="paneloa" class="panel panel-body">
                                    <div class="panel-default " align="center" >
                                        <div id="remove-oa" class="upload-msg">
                                        </div>

                                        <div class="panel-default " align="center" >
                                            <h5 class="backgroud btn-block">.</h5>
                                        </div>

                                        <h5 align="left">Lista de temáticas</h5>
                                        <div class="col-lg-12">

                                            <div class="col-lg-4 form-inline">
                                                <select class="form-control" id="tematicasSelected">

                                                </select>
                                            </div>
                                            <div class="col-lg-6  form-inline" >

                                                <button type="button" id="option1" class="col-lg-6 btn btn-primary" data-toggle="modal" data-target="#addObjectlearning"><i class='glyphicon glyphicon-plus'></i> OA</button>
                                                <button type="button" id="optionr2" id_oa="" name_oa=""class="col-lg-2 btn btn-danger btn-md invisible" data-toggle="modal" data-target="#oaDelete"><i class='glyphicon glyphicon-trash'></i> </button>
                                                <button type="button" id="optione2" class="col-lg-2 btn btn-info btn-md invisible" data-toggle="modal" data-target="#"><i class='glyphicon glyphicon-edit'></i> </button>
                                                <h4 class="invisible" id="pk_learningobject">?</h4>

                                            </div>
                                        </div>
                                        <div class="panel-body"></div>
                                        <div id="" class=" align="">
                                        <h5  class=" btn-block" align="left">Objetos de Aprendiazaje</h5>
                                        <ul class="list-group" id="learningobjects">
                                            <!--OA  here-->
                                        </ul>

                                    </div>
                                    <div class="panel-body">

                                    </div>
                                    <div class="panel-default " align="center" >
                                        <h5 class="backgroud btn-block">.</h5>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-12">
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-info-circle"></i>  <strong>Nota</strong> Espacio para administrar los OA por temáticas.
                            </div>
                        </div>

                    </div>



                    <div class="col-lg-12 col-md-12 col-xs-12" id="oaContentexercise">

                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="page-header">
                                    Ejercicios y recursos multimedia <small>(Panel)</small>
                                </h1>
                                <!-- <ol class="breadcrumb">
                                     <li class="active">
                                         <i class="fa fa-dashboard"></i>
                                     </li>
                                 </ol>-->
                            </div>
                        </div>



                        <div class="panel-group">
                            <div id="panelexercise" class="panel panel-body">
                                <div class="panel-default " align="center" >
                                    <div id="alert-exercise" class="upload-msg"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
                                </div>
                                <div class="panel-default " align="center" >
                                    <h5 class="backgroud btn-block">.</h5>

                                </div>

                                <div id="" class="panel-body ">
                                    <div class="panel-body">
                                        <div class=" col-lg-6 form-group">
                                            <label for="sel1">Selecciona una temática</label>
                                            <select class="form-control" id="bookexerciseSelect">
                                                <option>selecciona una temática</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6 form-group">
                                            <label for="sel1">Selecciona un OA:</label>
                                            <select class=" form-control" id="oaexerciseSelect">

                                            </select>
                                        </div>


                                    </div>
                                    <div class="col-lg-12">
                                        <button type="button" id="option2" class="col-lg-2 btn btn-primary btn-md  invisible" data-toggle="modal" data-target="#addexercise"><i class='glyphicon glyphicon-pencil'></i> </button>
                                        <button type="button" id="option4" class="col-lg-2 btn btn-primary  btn-md invisible" data-toggle="modal" data-target="#addresource"><i class='glyphicon glyphicon-picture'></i> </button>
                                        <button type="button" id="option5" class="col-lg-2 btn btn-primary btn-md  invisible" data-toggle="modal" data-target="#"><i class='glyphicon glyphicon-facetime-video'></i>  </button>
                                        <button type="button" id="option6"  class="col-lg-2 btn btn-primary  btn-md invisible" data-toggle="modal" data-target="#"><i class='glyphicon glyphicon-pencil'></i> </button>
                                        <button type="button" id="option7" value="" class="col-lg-1 btn btn-danger btn-md invisible" data-toggle="modal" data-target="#"><i class='glyphicon glyphicon-trash'></i> </button>
                                        <button type="button" id="option8" class="col-lg-1 btn btn-info btn-md invisible" data-toggle="modal" data-target="#"><i class='glyphicon glyphicon-edit'></i> </button>


                                    </div>
                                    <div class="col-lg-12 panel-body " id="scrOA" style=" margin-right: 2px;  max-height:50%;  overflow-y: scroll;">
                                        <ul class="list-group " id="exercises">
                                            <!--exercises  here-->

                                        </ul>



                                    </div>


                                </div>
                                <div class="panel-default " align="center" >
                                    <h5 class="backgroud btn-block">.</h5>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12">
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-info-circle"></i>  <strong>Nota</strong> Espacio para administrar los ejercicios y recursos multimedia.
                            </div>
                        </div>

                    </div>





                </div>
            </div>
        </div>


    </div>
</div><!-- End of #home-tiles -->
</div><!-- End of #main-content -->

<?php
require_once __DIR__. '/inc/modals.php';

?>

<?php include 'inc/footer.php'; ?>

<!-- jQuery (Bootstrap JS plugins depend on it) -->
<script src="js/script.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>

</body>


</html>

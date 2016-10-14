<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Objetos de Aprendizaje</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

</head>

<body>

<?php include 'inc/header.php'; ?>


<div id="main-content" class="container">
    <div id="home-tiles" class="row">

        <div class="col-lg-3 col-md-3 " id="optionsContent" >

            <div class="panel-group">
                <div id="paneloptions" class="panel panel-primary">
                    <div class="panel-heading">Opciones</div>

                    <div class="panel-body">
                        <div class="line"></div>
                        <button type="button" id="option0" class="btn btn-success btn-block" data-toggle="modal" data-target=".viewtematicas">Temáticas</button>
                        <div class="line"></div>
                        <button type="button" id="option1" class="btn btn-success btn-block" data-toggle="modal" data-target=".addObjectlearning">Crear objeto de aprendizaje</button>
                        <div class="line"></div>
                        <button type="button" id="option2" class="btn btn-success btn-block" data-toggle="modal" data-target=".addexercise">Agregar ejercicio</button>
                        <div class="line"></div>
                        <button type="button" id="option3" class="btn btn-success btn-block " data-toggle="modal">Agregar recurso</button>
                        <div class="line"></div>
                        <button type="button" id="option4" class="btn btn-danger btn-block">
                            Regresar a principal &nbsp;<i class="fa fa-sign-out"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-xs-12 " id="workspaceContent" >

            <div class="panel-group">
                <div id="panelworkspace" class="panel panel-primary">
                    <div class="panel-heading">Área de trabajo</div>

                    <div class="panel-body">
                        <!-- area para objetos de aprendizaje -->
                        <div class="col-lg-7 col-md-7 col-xs-12" id="oaContent">
                            <div class="panel-group">
                                <div id="paneloa" class="panel panel-default">
                                    <div class="panel-heading">Objetos de aprendizaje</div>
                                    <div class="panel-body " id="scrOA" style=" margin-right: 2px;  max-height:50%;  overflow-y: scroll;">
                                        <ul class="listaoa" id="learningobjects">
                                            <!--OA here-->

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-xs-12" id="exerciseCoenten">

                           <div class="panel-group">

                               <!-- <div id="panelexercise" class="panel panel-default">
                                    <div class="panel-heading">ejercicios de Mi primer OA</div>
                                    <div class="panel-body">

                                        <ul id="actividades" class="list-group">
                                            <li  class="btn btn-default btn-xs btn-block"><label>Ejercicio 1</label></li>
                                            <li  class="btn btn-default btn-xs btn-block"><label>Ejercicio 2</label></li>
                                        </ul>
                                    </div>
                                </div>-->
                            </div>

                        </div>


                    </div>
                        <!-- area para ejercicios de los OA -->

                </div>
            </div>
        </div>

       <!-- <div class="col-md-9 col-sm-12 col-xs-12">
            <p id="map-tile"><span> área de trabajo 1</span></p>
            <!-- <a href="https://www.google.com/maps/place/David+Chu's+China+Bistro/@39.3635874,-76.7138622,17z/data=!4m6!1m3!3m2!1s0x89c81a14e7817803:0xab20a0e99daa17ea!2sDavid+Chu's+China+Bistro!3m1!1s0x89c81a14e7817803:0xab20a0e99daa17ea" target="_blank">
              <div id="map-tile">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3084.675372390488!2d-76.71386218529199!3d39.3635874269356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c81a14e7817803%3A0xab20a0e99daa17ea!2sDavid+Chu&#39;s+China+Bistro!5e0!3m2!1sen!2sus!4v1452824864156" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                <span>map</span>
              </div>
            </a>-->
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
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
</body>


</html>

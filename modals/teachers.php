<?php
/**
 * Created by PhpStorm.
 * User: azulyoro
 * Date: 26/07/16
 * Time: 11:58 AM
 */?>
<!--addTeacher------------------------------------------------------------------------------------------------------------>
<div class="modal fade addTeacher" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--buttons------------------------------------------------------------------------------------------------>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Agregar nuevo maestro</h4>
            </div>
            <!--inputs------------------------------------------------------------------------------------------------->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputNameAddTeacher">Nombre:</label>
                            <input type="text" class="form-control" id="inputNameAddTeacher" placeholder="Type Name">
                        </div>
                    </div>
                </div>
            </div>
            <!--Buttons------------------------------------------------------------------------------------------------>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="addTeacher" class="btn btn-primary">Agregar maestro</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--editTeacher------------------------------------------------------------------------------------------------------------>
<div class="modal fade editTeacher" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--buttons------------------------------------------------------------------------------------------------>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Editar maestro</h4>
            </div>
            <!--inputs------------------------------------------------------------------------------------------------->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            <div class="search">
                                <input type="text" id="searchBoxTeacher" class="searchTextBox" placeholder="Teacher's name?" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="searchButton">
                            <i class="fa fa-search"></i>&nbsp;Buscar
                        </button>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group ">
                            <div id="contentTeachers" class="panel panel-primary searchContent">
                                <div class="panel-heading">Seleccionar maestro</div>
                                <div class="panel-body" style="max-height:87%; overflow-y: scroll;">
                                    <ul id="teachersFind" style="padding-left: 0px">
                                        <!--teacher here-->

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Buttons------------------------------------------------------------------------------------------------>
            <div class="modal-footer">
                <button type="button" id="deleteTeacher" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="updateTeacher" class="btn btn-primary">Actualziar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
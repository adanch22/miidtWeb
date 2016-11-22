<?php
/**
 * Created by PhpStorm.
 * User: azulyoro
 * Date: 26/07/16
 * Time: 11:58 AM
 */?>
<!--addStudent------------------------------------------------------------------------------------------------------------>
<div class="modal fade addStudent" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--buttons------------------------------------------------------------------------------------------------>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Agregar nuevo estudiante</h4>
            </div>
            <!--inputs------------------------------------------------------------------------------------------------->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputNameAddStudent">Nombre:</label>
                            <input type="text" class="form-control" id="inputNameAddStudent" placeholder="Type Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputMatriculaAddUSer">ID estudiante:</label>
                            <input type="number" class="form-control" id="inputMatriculaAddStudent" placeholder="Type Matricula">
                        </div>
                    </div>
                </div>
            </div>
            <!--Buttons------------------------------------------------------------------------------------------------>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="addStudent" class="btn btn-primary">Agregar estudiante</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--editStudent------------------------------------------------------------------------------------------------------------>
<div class="modal fade editStudent" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--buttons------------------------------------------------------------------------------------------------>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Agregar nuevo estudiante</h4>
            </div>
            <!--inputs------------------------------------------------------------------------------------------------->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            <div class="search">
                                <input type="text" id="searchBoxStudent" class="searchTextBox" placeholder="Student's name?" required>
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
                            <div id="jaja" class="panel panel-primary searchContent">
                                <div class="panel-heading">Seleccionar estudiante</div>
                                <div class="panel-body" style="max-height:87%; overflow-y: scroll;">
                                    <ul id="studentsFind" style="padding-left: 0px">
                                        <!--students here-->

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Buttons------------------------------------------------------------------------------------------------>
            <div class="modal-footer">
                <button type="button" id="deleteStudent" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="updateStudent" class="btn btn-primary">Actualziar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
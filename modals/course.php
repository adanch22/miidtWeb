<?php
/**
 * Created by PhpStorm.
 * User: azulyoro
 * Date: 26/07/16
 * Time: 11:17 AM
 */
?>

<div class="modal fade addCourse" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" id="buttonCloseAddCourse" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Agregar Curso</h4>
            </div>
         
           
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputNameAddCourse">Nombre del curso:</label>
                            <input type="text" class="form-control" id="inputNameAddCourse" placeholder="Type Name">
                            <br>
                            <select class="form-control" id="levelSelected">
                                <option>Basico</option>
                               <!--  <option>Intermedio</option> -->
                            </select>

                        </div>
                    </div>
                </div>
            </div>

           
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                <button type="button" id="addCourse" class="btn btn-primary">Crear</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade deleteCourse" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" id="buttonCloseDeleteCourse"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Eliminar o limpiar contenido del Curso</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="question" ></label>
                            <label for="myalue" style="vertical-align: middle"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="deleteCourse" class="btn btn-primary">Eliminar Curso </button>
                <button type="button" id="cleanCourse" class="btn btn-primary">Limpiar Conenido de Curso</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
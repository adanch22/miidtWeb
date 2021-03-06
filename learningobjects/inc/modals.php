<!--Modal agregar un OA -->
<div class="modal fade" id="addObjectlearning" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Objeto de Aprendizaje</h4>
            </div>

            <div class="modal-body">
                <div id="upload-lobjects" class="upload-msg"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->

                <form>

                    <div class="form-group">
                        <label for="exampleSelect1">Tipo de objeto de aprendizaje  </label>
                        <select class="form-control" id="typeSelected">
                            <option>Por defecto</option>
                            <option>VideoQuiz</option>
                        </select>

                        <h4> --------------------------------------- Metadatos ---------------------------------------</h4>
                        <label for="recipient-name" class="control-label">Titulo del Objeto de aprendizaje </label>
                        <input type="text" id="inputNameOA" class="form-control" placeholder="Escribe nombre de OA">

                        <label for="exampleSelect1">Idioma del Objeto de aprendizaje </label>
                        <select class="form-control" id="languageSelected">
                            <option>Español</option>
                            <option>Ingles</option>
                        </select>
                        <label for="recipient-name" class="control-label">Descripción</label>
                        <input type="text" id="inputDescription" class="form-control" placeholder="Escribe descripción del OA">
                    </div>


                    <div class="form-group">
                        <div class="col-lg-6 form-group">
                            <label for="recipient-name" class="control-label">Version</label>
                            <input type="number" id="inputVersion" class="form-control" placeholder="V1.1" >
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="recipient-name" class="control-label">Autor</label>
                            <input type="text" id="inputAutor" class="form-control" placeholder="Ej. Adán Chávez ">
                        </div>

                    </div>
                    <div class="form-group">
                        <h4> --------------------------------------- Metadatos ---------------------------------------</h4>

                    </div>


                    <!-- <div class="form-group">
                         <label for="exampleSelect1">Seleccione el nivel del OA(actividad) </label>
                         <select class="form-control" id="levelSelectedoa">
                             <option>Basico</option>
                             <option>Intermedio</option>
                             <option>Avanzado</option>

                         </select>
                     </div>-->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                <button type="button" id="addOA" class="btn btn-primary">Crear OA(actividad)</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--Modal agregar un ejercicios -->
<div class="modal fade" id="addexercise" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="titleh4" class="modal-title">Agregar ejercicio a Objeto de Aprendizaje</h4>
            </div>

            <div class="modal-body">
                <div id="upload-exercise"  class="upload-msg"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->

                <form>

                    <div class="form-group">
                        <label for="exampleSelect1">Nombre del objeto de Aprendizaje</label>
                        <!--<select class="form-control" id="learningobjectsSelected">

                        </select>-->
                        <h5  id="learning_name">nombre del OA</h5>

<!--                        <label for="recipient-name" class="control-label">Título</label>
                        <input type="text" id="inputNameExercise" class="form-control" placeholder="Escribe un título breve(opcional)">-->
                        <label for="recipient-name" class="control-label">Descripción del ejercicio</label>
                        <input type="text" id="inputDescriptionExercise" class="form-control" placeholder="Describe el ejercicio">
                        <div id="optionsquestion">
                            <label class="radio-inline"><input type="radio" id="buttoncuestionary"name="optradio" value="1">Pregunta abierta</label>
                            <label class="radio-inline"><input type="radio" id="buttonoptions" name="optradio" value="2">Pregunta opción múltiple</label>
                        </div>
                        <!--<div class="disabled" id="optionsquestion2">
                            <label class="radio-inline disabled"><input type="radio" id="buttoncuestionary2"name="optradio" value="1">Pregunta abierta con imagen</label>
                            <label class="radio-inline disabled"><input type="radio" id="buttonoptions2" name="optradio" value="2">Pregunta opción múltiple con imagen</label>
                        </div>-->
                        <label for="recipient-name" class="control-label">Pregunta</label>
                        <input tye="text" id="inputQuestion" class="form-control"placeholder="Escribe la pregunta del ejercicio">


                    </div>

                    <div class="form-group" id="cuestionary">
                        <label for="recipient-name" class="control-label">Respuesta correcta</label>
                        <input type="text" id="inputAnswer" class="form-control"placeholder="Escribe la respuesta de la pregunta anterior">
                    </div>

                    <div class="form-group" id="multipleoption">

                        <h5 for="recipient-name" class="control-label">Respuesta 1</h5>
                        <input type="text" id="inputAnswer1" class="form-control"placeholder="Escribe posible respuesta">
                        <h5 for="recipient-name" class="control-label">Respuesta 2</h5>
                        <input type="text" id="inputAnswer2" class="form-control"placeholder="Escribe posible respuesta">
                        <h5 for="recipient-name" class="control-label">Respuesta 3</h5>
                        <input type="text" id="inputAnswer3" class="form-control"placeholder="Escribe posible respuesta">
                        <h5 class="form-inline">Selecciona respuesta correcta:</h5>
                        <label id="answer1" class="radio-inline"><input type="radio" name="ansradio" value="1" checked>[ 1 ]</label>
                        <label id="answer2" class="radio-inline"><input type="radio" name="ansradio" value="2">[ 2 ]</label>
                        <label id="answer3" class="radio-inline"><input type="radio" name="ansradio" value="3">[ 3 ]</label>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                <button type="button" id="addexercise"class="btn btn-primary">Agregar ejercicio</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /Modal para agregar tematicas -->
<div class="modal fade  viewtematicas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Temáticas</h4>
            </div>
            <div class="modal-body">
                <div id="upload-tematica" class="upload-msg"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
                <div class="form-group">
                    <h4 class="modal-title">Escribe nueva tématica</h4>
                    <input type="text" id="inputTematica" class="form-control" placeholder="Ej. Métodos Numéricos" >
                    <div class="line"></div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                <button type="button" id="addtematica" class="btn btn-success">Agregar temática</button>
                <!--   <button type="button" class="btn btn-primary">Guardar Cambios</button> -->
            </div>
          </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- /Modal para subir recursos multimedia  -->
<div class="modal fade " id="addresource"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Subir recursos a Objeto de aprendizaje</h4>
            </div>
            <div class="modal-body">


                    <div class="text-center">
                        <form>
                            <div class="form-group">
                                <label id="titlerm" for="learningobjectsSelected">Objeto de Aprendizaje a incluir el recurso multimedia </label>
<!--                                <select class="form-control" id="learningobjectsResource">-->
<!--                                    <!-- learningObjects here -->
<!--                                </select>-->
                                <h5  id="resource_name">nombre del OA</h5>

                            </div>

                            <div class="form-group">
                                <label id="type1" class="radio-inline"><input type="radio" name="typeradio" value="image" checked>IMAGEN</label>
                                <label id="type2" class="radio-inline"><input type="radio" name="typeradio" value="video">VIDEO</label>
                                <label id="type3" class="radio-inline"><input type="radio" name="typeradio" value="pdf">PDF</label>

                            </div>

                            <div class="form-group">
                                <center><input class="btn btn-primary" type="file"  id="fileToUpload" onchange="upload_image();"></center>
                                <p class="help-block">Selecciona un archivo.</p>
                            </div>
                            <div class="upload-msg"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->

                        </form>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                <!--   <button type="button" class="btn btn-primary">Guardar Cambios</button> -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- /Modal para eliminar temáticas  -->
<div class="modal fade " id="remove-data"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Alerta</h4>
            </div>
            <div class="modal-body">
                <h4>¿Esta seguro de eliminar la tématica?</h4>

            </div>
            <div class="modal-footer">
                <button id="optionrx1" type="button" class="btn btn-info" data-dismiss="modal">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <!--   <button type="button" class="btn btn-primary">Guardar Cambios</button> -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- /Modal para eliminar oa  -->
<div class="modal fade " id="remove-data2"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Atención</h4>
            </div>
            <div class="modal-body">
                <h4>¿Esta seguro de eliminar el objeto de aprendizaje?</h4>

            </div>
            <div class="modal-footer">
                <button id="optionrx2" type="button" class="btn btn-info" data-dismiss="modal">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <!--   <button type="button" class="btn btn-primary">Guardar Cambios</button> -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- /Modal para eliminar ejercicios y/ recursos multimedia -->
<div class="modal fade " id="remove-data3"  tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Atención</h4>
            </div>
            <div class="modal-body">
                <h4>¿Esta seguro de eliminar el ejercicio/recurso multimedia?</h4>

            </div>
            <div class="modal-footer">
                <button id="optionrx3" type="button" class="btn btn-info" data-dismiss="modal">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <!--   <button type="button" class="btn btn-primary">Guardar Cambios</button> -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Modal agregar actividades al videoQuiz -->
<div class="modal fade" id="addexerciseVideoQuiz" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="titleh4" class="modal-title">Agregar actividades al OA VideoQuiz</h4>
            </div>

            <div class="modal-body">
                <div id="upload-exerciseVQ"  class="upload-msg"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->

                <form>

                    <div class="form-group">
                         <h5  id="learning_nameVQ">Nombre del OA</h5>

                        <label for="recipient-name" class="control-label">Tiempo donde aparece esta actividad en  el video </label>
                        <input type="number" id="inputDescriptionExerciseVQ" class="form-control" placeholder="Ejemplo: 30 [segundos] ">
                        <!--<div class="disabled" id="optionsquestion2">
                            <label class="radio-inline disabled"><input type="radio" id="buttoncuestionary2"name="optradio" value="1">Pregunta abierta con imagen</label>
                            <label class="radio-inline disabled"><input type="radio" id="buttonoptions2" name="optradio" value="2">Pregunta opción múltiple con imagen</label>
                        </div>-->
                        <label for="recipient-name" class="control-label">Pregunta</label>
                        <input tye="text" id="inputQuestionVQ" class="form-control"placeholder="Escribe la pregunta del ejercicio">

                    </div>
                    <div class="form-group" id="multipleoption">

                        <h5 for="recipient-name" class="control-label">Respuesta 1</h5>
                        <input type="text" id="inputAnswer1VQ" class="form-control"placeholder="Escribe posible respuesta">
                        <h5 for="recipient-name" class="control-label">Respuesta 2</h5>
                        <input type="text" id="inputAnswer2VQ" class="form-control"placeholder="Escribe posible respuesta">
                        <h5 for="recipient-name" class="control-label">Respuesta 3</h5>
                        <input type="text" id="inputAnswer3VQ" class="form-control"placeholder="Escribe posible respuesta">
                        <h5 class="form-inline">Selecciona respuesta correcta:</h5>
                        <label id="answer1VQ" class="radio-inline"><input type="radio" name="ansradioVQ" value="1" checked>[ 1 ]</label>
                        <label id="answer2VQ" class="radio-inline"><input type="radio" name="ansradioVQ" value="2">[ 2 ]</label>
                        <label id="answer3VQ" class="radio-inline"><input type="radio" name="ansradioVQ" value="3">[ 3 ]</label>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                <button type="button" id="addexerciseVQ"class="btn btn-primary">Agregar ejercicio</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

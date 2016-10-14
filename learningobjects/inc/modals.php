<!--Modal agregar un OA -->
<div class="modal fade addObjectlearning" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Objeto de Aprendizaje</h4>
            </div>

            <div class="modal-body">
                <form>

                    <div class="form-group">
                        <h4>General</h4>
                        <label for="recipient-name" class="control-label">Titulo del Objeto de aprendizaje </label>
                        <input type="text" id="inputNameOA" class="form-control" placeholder="Escribe nombre de OA">

                        <label for="exampleSelect1">Idioma del Objeto de aprendizaje </label>
                        <select class="form-control" id="levelSelectedoa">
                            <option>Español</option>
                            <option>Ingles</option>
                        </select>
                        <label for="recipient-name" class="control-label">Descripción</label>
                        <input type="text" id="inputDescription" class="form-control" placeholder="Escribe descripción del OA">
                    </div>


                    <div class="form-group">
                        <h4>Ciclo de Vida</h4>
                        <label for="recipient-name" class="control-label">Version</label>
                        <input type="text" id="inputVersion" class="form-control" placeholder="V1.1" >
                        <label for="recipient-name" class="control-label">Autor</label>
                        <input type="text" id="inputAutor" class="form-control" placeholder="Ej. Adán Chávez ">
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="addOA"class="btn btn-primary">Crear OA(actividad)</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--Modal agregar un ejercicios -->
<div class="modal fade addexercise" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar ejercicio a Objeto de Aprendizaje</h4>
            </div>

            <div class="modal-body">
                <form>

                    <div class="form-group">
                        <label for="exampleSelect1">Selecciona el OA a incluir el ejercicio </label>
                        <select class="form-control" id="levelSelectedoa">
                            <option>Mi primer OA</option>
                            <option>Mi segundo OA</option>
                        </select>

                        <label for="recipient-name" class="control-label">Título del ejercicio</label>
                        <input type="text" id="inputNameExercise" class="form-control">

                        <label for="recipient-name" class="control-label">Descripción del ejercicio</label>
                        <input type="text" id="inputDescriptionExercise" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Escribre la pregunta</label>
                        <input type="text" id="inputQuestion1" class="form-control">
                        <label for="recipient-name" class="control-label">Respuesta correcta</label>
                        <input type="text" id="inputAnswer1" class="form-control">
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="addOA"class="btn btn-primary">Crear OA(actividad)</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- /Modal para agregar tematicas -->
<div class="modal fade viewtematicas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Temáticas</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

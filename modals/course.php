<?php
/**
 * Created by PhpStorm.
 * User: azulyoro
 * Date: 26/07/16
 * Time: 11:17 AM
 */
?>
<!--AddCourse------------------------------------------------------------------------------------------------------->
<div class="modal fade addCourse" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--configs------------------------------------------------------------------------------------------------>
            <div class="modal-header">
                <button type="button" id="buttonCloseAddCourse" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Add course</h4>
            </div>
            <!--inputs------------------------------------------------------------------------------------------------->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputNameAddCourse">Name:</label>
                            <input type="text" class="form-control" id="inputNameAddCourse" placeholder="Type Name">
                            <br>
                            <select class="form-control" id="levelSelected">
                                <option>Basic</option>
                                <option>Intermediate</option>
                            </select>

                        </div>
                    </div>
                </div>
            </div>
            <!--Buttons------------------------------------------------------------------------------------------------>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="addCourse" class="btn btn-primary">Create</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--DeleteCourse---------------------------------------------------------------------------------------------------->
<div class="modal fade deleteCourse" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--configs------------------------------------------------------------------------------------------------>
            <div class="modal-header">
                <button type="button" id="buttonCloseDeleteCourse"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Remove or clean course</h4>
            </div>
            <!--inputs------------------------------------------------------------------------------------------------->
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
            <!--Buttons------------------------------------------------------------------------------------------------>
            <div class="modal-footer">
                <button type="button" id="deleteCourse" class="btn btn-primary">Delete</button>
                <button type="button" id="cleanCourse" class="btn btn-primary">Clean</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
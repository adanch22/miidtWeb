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
                <h4 class="modal-title" id="gridSystemModalLabel">Add new student</h4>
            </div>
            <!--inputs------------------------------------------------------------------------------------------------->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputNameAddStudent">Name:</label>
                            <input type="text" class="form-control" id="inputNameAddStudent" placeholder="Type Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputMatriculaAddUSer">Student ID:</label>
                            <input type="number" class="form-control" id="inputMatriculaAddStudent" placeholder="Type Matricula">
                        </div>
                    </div>
                </div>
            </div>
            <!--Buttons------------------------------------------------------------------------------------------------>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="addStudent" class="btn btn-primary">Add student</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--DeleteStudent--------------------------------------------------------------------------------------------------------->
<div class="modal fade deleteStudent" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--configs------------------------------------------------------------------------------------------------>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Delete students</h4>
            </div>
            <!--list users--------------------------------------------------------------------------------------------->
            <div class="modal-body">
                <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Select student to delete</div>
                        <div class="panel-body" style="max-height:50%; overflow-y: scroll;">
                            <ul id="students" class="usercontent" style="padding-left: 0px">
                                <!--students here-->

                            </ul>
                        </div>
                    </div>
                </div>
                <!--Inputs--------------------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="labelusername">Matricula:</label>
                            <input type="text" class="form-control" id="inputMatriculaDelete" placeholder="Type Matricula">
                        </div>
                    </div>
                </div>
            </div>
            <!--Buttons------------------------------------------------------------------------------------------------>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="deleteStudent" class="btn btn-primary">Delete</button>
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
                <h4 class="modal-title" id="gridSystemModalLabel">Add new student</h4>
            </div>
            <!--inputs------------------------------------------------------------------------------------------------->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            <div class="search">
                                <input type="text" id="searchbox" class="searchTextBox" placeholder="Student's name?" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="searchButton">
                            <i class="fa fa-search"></i>&nbsp;Search
                        </button>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group ">
                            <div id="jaja" class="panel panel-primary searchContent">
                                <div class="panel-heading">Select student</div>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="updateStudent" class="btn btn-primary">Update</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
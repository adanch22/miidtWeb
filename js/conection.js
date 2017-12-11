$(document).ready(function () {
    getCourses();
    setOptions();
    var fileExtension = "";
    var fileName="";
    var searching=false;
    var courses;

    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {
        //obtenemos un array con los datos del archivo
        var file = $("#imagen")[0].files[0];
        //obtenemos el nombre del archivo
        fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        fileName = fileName.substr(0,fileName.lastIndexOf('.'));
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;

        if(fileName.length>10){
            $('#loadImage').html(fileName.substr(0,9)+"..."+fileExtension);
        }else{
            $('#loadImage').html(fileName+"."+fileExtension);
        }
    });

//action users buttons
    $('ul#users li').on('click', function () {
        $('ul#users li').removeClass('btn-danger');
        $(this).addClass('btn-danger');
        $('input#inputMatriculaDelete').val($(this).prop('id'));
    });

//get msg from groups
    function getMessages(id) {
        $('ul#messages').html("");
        $.getJSON("v1/course/messages/" + id, function (data) {
            var li = '';
            $.each(data.messages, function (i, data) {
                if(data.image==""){
                    li += '<li class="others" style="padding-right: 20px;"><label class="name">' + data.admin.admin_name +
                        ':</label><div class="message">' + data.message + '</div><div class="clear"></div></li>';
                }else{
                    li += '<li class="others" style="padding-right: 20px;"><label class="name">' + data.admin.admin_name +
                        ':</label><mg  class="message">' + data.message + '<br><img src="images/'+data.image+'"class="imageMessage"></div><div class="clear"></div></li>';
                }
            });
            $('ul#messages').html(li);
            $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
        }).done(function () {

        }).fail(function () {
            alert('Sorry! Unable to fetch topic messages');
        }).always(function () {

        });

        // attaching the chatroom id to send button
        $('#send').attr('course_id', id);
    }

//get courses
    function getCourses() {
        $.getJSON("v1/courses/"+admin_id, function (data) {
            var li = '';
            $.each(data.course, function (i, course) {
                courses=
                li += '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Nombre: </label><span>'+" "+course.course_name+' </span></li>';
            });
            $('ul#courses').html(li);
            $('ul#courses li').click(function() {
                $('ul#courses li').removeClass('btn-primary');
                $(this).addClass('btn-primary');
                // attaching the chatroom id to send button
                $('button#remove').attr('course_name', $(this).attr('course_name'));
                getMessages($(this).prop('id'));
                $('button#remove').removeClass("disabled");
                $('button#remove').attr("data-target", ".deleteCourse");

                $('button#optionAddStudent').removeClass("disabled");
                $('button#optionAddStudent').attr("data-target", ".addStudent");

            });
           // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
        }).done(function () {

        }).fail(function () {
            alert('Sorry! Unable to fetch topic messages');
        }).always(function () {

        });
    }

    function setOptions() {
        $.getJSON("v1/admin/type/"+admin_id, function (data) {
            if(data.is_teacher){//Teacher
                $('div#onlyAdmin').html("");
            }

        }).done(function () {

        }).fail(function () {
            alert('Sorry! Internal error');
        }).always(function () {

        });
    }

    //get classrooms
    function getStudents() {
        var c_id = $('button#send').attr("course_id");
        $.getJSON("v1/students/"+c_id, function (data) {
            var li = '';
            $.each(data.student, function (i, student) {
                li += '<li  class="btn btn-default btn-sm btn-block" id='+student.matricula+'>'+student.student_name+'</li>';
            });
            $('ul#students').html(li);
            $('ul#students li').click(function() {
                $('ul#students li').removeClass('btn-primary');
                $(this).addClass('btn-primary');
                $('#inputMatriculaDelete').val($(this).attr('id'));
            });
            // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
        }).done(function () {

        }).fail(function () {
            alert('Sorry! Unable to fetch students');
        }).always(function () {

        });
    }

//action for button SEND
    function sendMessage(msg, c_id, img){
        $.post("v1/course/" + c_id + '/message/',
            {admin_id: admin_id, message: msg, image:img},
            function (data) {
                if (data.message && !data.error) {
                    if(data.message.image==""){
                        var li = '<li class="others" style="padding-right: 20px;"><label class="name">' + data.admin.admin_name +
                            ':</label><div class="message">' + data.message.message + '</div><div class="clear"></div></li>';
                    }else{
                        var li = '<li class="others" style="padding-right: 20px;"><label class="name">' + data.admin.admin_name +
                            ':</label><div class="message">' + data.message.message + '<br><img src="images/'+data.message.image+'"class="imageMessage"></div><div class="clear"></div></li>';
                    }
                    $('ul#messages').append(li);
                    $('#message').val("");
                    $("#scrollMsj").animate({ scrollTop: $('#scrollMsj').prop("scrollHeight")}, 1000);
                } else {
                    $('#message').val("");
                    getMessages(c_id);
                    alert("Message send to the server, but do not the push notification! Please contact the admin cezamacona@uagro.mx");
                }
                $('#loadImage').html("Select image");
                fileName="";
            }).done(function () {

        }).fail(function () {
            alert('Sorry! Internal error');
        }).always(function () {
            $('#loader').hide();
        });
    };

    $('#send').click(function() {
            $('#loader').show();
            var msg = $('#message').val();
            var c_id = $(this).attr('course_id');

        if (msg.trim().length === 0) {
                alert('Enter a message');
                return;
            } else if (fileName.trim().length === 0) {
                sendMessage(msg,c_id,"NO");
            } else {
                //información del formulario
                var formData = new FormData($(".formulario")[0]);
                //hacemos la petición ajax
                $.ajax({
                    url: 'ajax_php_file.php',
                    type: 'POST',
                    // Form data
                    //datos del formulario
                    data: formData,
                    //necesario para subir archivos via ajax
                    cache: false,
                    contentType: false,
                    processData: false,
                    //mientras enviamos el archivo
                    beforeSend: function () {
                        //alert("Subiendo la imagen, por favor espere...");

                    },
                    //una vez finalizado correctamente
                    success: function (data) {
                        $('#loadImage').html("Uploaded");
                        sendMessage(msg,c_id,data);
                    },
                    //si ha ocurrido un error
                    error: function () {
                        alert("Error while uploading image");
                    }
                });
            }
        }


    );


//action for button ADDSTUDENT
    $('button#addStudent').on('click', function () {
        var nam = $('input#inputNameAddStudent').val();
        var mat = $('input#inputMatriculaAddStudent').val();
        var c_id = $('button#send').attr("course_id");
        if (nam && mat && c_id) {
            $.post("v1/student/add/",
                {student_name: nam, matricula: mat, password: "miidt2016"},
                function (data) {
                    if (!data.error) {
                        var li = '<li  class="btn btn-default btn-sm btn-block" id='+mat+'>'+nam+'</li>';
                        $('ul#students').append(li);
                        $('ul#students li').click(function() {
                        $('ul#students li').removeClass('btn-primary');
                        $(this).addClass('btn-primary');
                        $('#inputMatriculaDelete').val($(this).attr('id'));
            });

                        assigCourse(data.student_id, c_id);
                    }else{
                        alert(data.message);
                    }
                }).done(function () {

            }).fail(function () {
                alert('Sorry! Internal error');
            }).always(function () {

            });
        }else{
            alert("Empty fields")
        }
    });
    function assigCourse(s_id, c_id) {
        $.post("v1/student_course/",
            {student_id: s_id, course_id: c_id},
            function (data) {
                if(!data.error){
                    alert("Student registered");
                }else{
                    alert(data.message);
                }
            }).done(function () {

        }).fail(function () {
            alert('Sorry! Internal error');
        }).always(function () {

        });
    }

    //action for button ADDTEACHER
    $('button#addTeacher').on('click', function () {
        var nam = $('input#inputNameAddTeacher').val();
        if (nam!=null && nam!="") {
            $.post("v1/admin/register/",
                {admin_name: nam, is_teacher: "1", password: "ciex2016"},
                function (data) {
                    alert(data.message);
                }).done(function () {

            }).fail(function () {
                alert('Sorry! Internal error');
            }).always(function () {

            });
        }else{
            alert("Empty fields")
        }
    });


//action for button SEARCHSTUDENT
    $('.searchButton').click(function(){
        if($('.searchTextBox').val() == '')
        {
            $('.searchTextBox').toggleClass('Open');
        }
        else
        {
            $('#studentsFind').html('<h1 class="searching">¡¡Have a good day!!<br>¡¡Be happy!!!</h1>')
        }
    });
//Fetch the students
    $('.searchTextBox').on('keyup', function(event){
        $('#studentsFind').html('');
        if(!searching && $('.searchTextBox').val().length >= 2){

            var nam = $('.searchTextBox').val();
            searching=true;
            $.post("v1/student/search/",
                {student_name: nam},
                function (data) {
                    if (!data.error) {
                        var li = '';
                        var course='';
                        $.each(data.student, function (i, student) {
                            course=''
                            $.each(student.course, function (j, aux) {
                                course += aux+' ';
                            });
                            course=course.substring(0,course.length-1);
                            li += '<li  class="btn btn-default btn-sm btn-block" matricula="'+student.matricula+'" date="'+student.created_at+'" course="'+course+'" >'+student.student_name+'</li>';
                        });
                        $('#studentsFind').html(li);
                        $('ul#studentsFind li').click(function() {
                            $('ul#studentsFind li').hide();
                            $(this).show();
                            $(this).addClass('btn-primary');
                            var li =
                                    '<div class="modal-body">' +
                                        '<div class="row">' +
                                            '<div class="col-md-4 col-sm-4 col-xs-4">' +
                                                '<div class="form-group">' +
                                                    '<img src="images/icon-person.png" alt="HTML5 Icon" width="128" height="128">' +
                                                    '<label>'+$(this).attr("date")+'</label>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="col-md-8 col-sm-8 col-xs-8">' +
                                                '<div class="form-group">' +
                                                    '<label for="inputNameEditStudent">Name:</label>' +
                                                    '<input type="text" class="form-control" id="inputNameEditStudent" placeholder="'+$(this).text()+'">' +
                                                    '<br><label for="inputMatriculaEditStudent">Matricula:</label>' +
                                                    '<input type="text" class="form-control" id="inputMatriculaEditStudent" placeholder="'+$(this).attr("matricula")+'">' +
                                                    '<br><label for="inputLevelEditStudent">Courses:</label>' +
                                                    '<input type="text" class="form-control" id="inputLevelEditStudent" placeholder="Write at least one course!">' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>'+
                                    '</div>';
                            $('#studentsFind').html(li);
                            $('#inputLevelEditStudent').val($(this).attr("course"));
                        });
                        if(!$('.searchContent').hasClass("OpenFind") && li!=''){
                            $('.searchContent').toggleClass('OpenFind');
                        }
                        searching=false;
                    }else{
                        alert(data.message);
                        searching=false;
                    }
                }).done(function () {

            }).fail(function () {
                alert('Sorry! Internal error');
                searching=false;
            }).always(function () {
                searching=false;
            });
            searching=false;
        }else{
            if($('.searchContent').hasClass("OpenFind")){
                $('.searchContent').toggleClass('OpenFind');
            }
        }
    });


//Fetch the teachers
    $('#searchBoxTeacher').on('keyup', function(event){
        $('#teachersFind').html('');
        if(!searching && $('#searchBoxTeacher').val().length >= 2){
            var nam = $('#searchBoxTeacher').val();
            searching=true;
            $.post("v1/admin/teacher/search/",
                {admin_name: nam},
                function (data) {
                    var li = '';
                    $.each(data.admin, function (i, admin) {
                        li += '<li  class="btn btn-default btn-sm btn-block" date="'+admin.created_at+'" id="'+admin.admin_id+'" >'+admin.admin_name+'</li>';
                    });

                    $('#teachersFind').html(li);
                    $('ul#teachersFind li').click(function() {
                        $('ul#teachersFind li').hide();
                        $(this).show();
                        $(this).addClass('btn-primary');
                        var li =
                            '<div class="modal-body">' +
                            '<div class="row">' +
                            '<div class="col-md-4 col-sm-4 col-xs-4">' +
                            '<div class="form-group">' +
                            '<img src="images/icon-person.png" alt="HTML5 Icon" width="128" height="128">' +
                            '<label>'+$(this).attr("date")+'</label>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-md-8 col-sm-8 col-xs-8">' +
                            '<div class="form-group">' +
                            '<label for="inputNameEditStudent">Name:</label>' +
                            '<input type="text" class="form-control" id="inputNameEditStudent" placeholder="'+$(this).text()+'">' +
                            '<br><label for="inputLevelEditStudent">Courses:</label>' +
                            '<input type="text" class="form-control" id="inputLevelEditStudent" placeholder="Write at least one course!">' +
                            '</div>' +
                            '</div>' +
                            '</div>'+
                            '</div>';
                        $('#teachersFind').html(li);
                        $('#inputLevelEditTeacher').val($(this).attr("course"));
                    });
                    if(!$('#contentTeachers').hasClass("OpenFind") && li!=''){
                        $('#contentTeachers').toggleClass('OpenFind');
                    }
                    searching=false;
                }).done(function () {

            }).fail(function () {
                alert('Sorry! Internal error');
                searching=false;
            }).always(function () {
                searching=false;
            });
            searching=false;
        }else{
            if($('.searchContent').hasClass("OpenFind")){
                $('.searchContent').toggleClass('OpenFind');
            }
        }
    });

//action for button DELETESTUDENT
    $('button#deleteStudent').on('click', function () {
        var mat = $('input#inputMatriculaEditStudent').attr('placeholder');
        if(mat != null && mat != ""){
            $.post("v1/student/delete/",
                {matricula: mat},
                function (data) {
                    alert(data.message);
                    if(!data.error){
                        $('#studentsFind').html('');
                    }
                }).done(function () {

            }).fail(function () {
                alert('Sorry! Internal error');
            }).always(function () {

            });
        }
    });

//action for button ADDCOURSE
    $('button#addCourse').on('click', function () {
        var nam = $('input#inputNameAddCourse').val();
        var lev_id = $('select#levelSelected').prop("selectedIndex")+1;
        $.post("v1/course/add",
            {course_name: nam, level_id:lev_id},
            function (data) {
                if(!data.error){
                    var li = '<li  class="btn btn-default btn-block" course_name='+nam+' id='+data.course_id+'><label>Group: </label><span>'+" "+nam+' </span></li>';
                    $('ul#courses').append(li);
                    $('ul#courses li').last().click(function() {
                        $('ul#courses li').removeClass('btn-primary');
                        $(this).addClass('btn-primary');
                        // attaching the chatroom id to send button
                        $('button#remove').attr('course_name', $(this).attr('course_name'));
                        getMessages($(this).prop('id'));
                        $('button#remove').removeClass("disabled");
                        $('button#remove').attr("data-target", ".deleteCourse");

                        $('button#optionAddStudent').removeClass("disabled");
                        $('button#optionAddStudent').attr("data-target", ".addStudent");

                        $('button#optionDeleteStudent').removeClass("disabled");
                        $('button#optionDeleteStudent').attr("data-target", ".deleteStudent");
                    });
                    $('#inputNameAddCourse').val("");
                    $("#scrCourse").animate({ scrollTop: $('#scrCourse').prop("scrollHeight")}, 1000);
                }else{
                    alert(data.message);
                }
            }).done(function () {

        }).fail(function () {
            alert('Sorry! Internal error');
        }).always(function () {
        });
    });

//action for button DELETECOURSE
    $('button#deleteCourse').on('click', function () {
        var c_id = $('button#send').attr("course_id");
        $.post("v1/course/delete",
            {course_id: c_id},
            function (data) {
                if(!data.error){
                    $('ul#courses li#'+c_id).remove();
                    $('button#buttonCloseDeleteCourse').click();
                    $('button#remove').addClass("disabled");
                    $('button#remove').attr("data-target", "");
                    $('button#optionAddStudent').addClass("disabled");
                    $('button#optionAddStudent').attr("data-target", "");
                    alert(data.message);
                }else{
                    alert(data.message);
                }
            }).done(function () {

        }).fail(function () {
            alert('Sorry! Internal error');
        }).always(function () {

        });
    });
//action for button CLEANCOURSE
    $('button#cleanCourse').on('click', function () {
        var c_id = $('button#send').attr("course_id");
        $.post("v1/course/clean",
            {course_id: c_id},
            function (data) {
                if(!data.error){
                    $('ul#messages').html("");
                    $('button#buttonCloseDeleteCourse').click();
                }else{
                    alert(data.message);
                }

            }).done(function () {

        }).fail(function () {
            alert('Sorry! Internal error');
        }).always(function () {
            $('#loader').hide();
        });
    });



//******************* OPTION BUTTONS *********************
    $('button#downloadApp').on('click',function(){
        window.open("/../miidt/downloadApp.php\"","_self");
    });

    $('button#remove').on('click',function(){
        $("label[for='question']").html("Course "+$('#remove').attr('course_name')+". What do you want to do?");
    });

    $('button#closeSession').on('click',function(){
        window.open("register/logout.php","_self");
    });

    $('button#optionDeleteStudent').on('click',function(){
        getStudents();
    });

    $('button#optionEditStudent').on('click',function(){
        $('#searchBoxStudent').val('');
        $('#searchBoxStudent').removeClass('Open');
        $('.searchContent').removeClass('OpenFind');
    });


    //codigo de boton para abir /ciex/learningobjects/index.php
    $('button#openlearningObjects').on('click',function(){
        window.open("learningobjects/index.php","_self");
    });


});


function cleanSpecialChar(el){
    var textfield = document.getElementById(el);
    var regex = /[^a-z 0-9]/gi;
    if(textfield.value.search(regex) > -1) {
        textfield.value = textfield.value.replace(regex, "");
    }
}
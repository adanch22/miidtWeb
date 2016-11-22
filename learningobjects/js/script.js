/*// DOM manipulation
// console.log(document.getElementById("title"));
// console.log(document instanceof HTMLDocument);*/

$(document).ready(function(){



    getbooks();


    $("#buttoncuestionary").on( "click", function() {
        $('#cuestionary').show(); //muestro mediante id
        $('#multipleoption').hide(); //muestro mediante id
       // $('.target').show(); //muestro mediante clase
    });
    $("#buttonoptions").on( "click", function() {
        $('#cuestionary').hide(); //oculto mediante id
        $('#multipleoption').show(); //oculto mediante id

        //  $('.target').hide(); //muestro mediante clase
    });


    //Evento cambiar las opciones del selector de objetos de aprendiazaje para agregar ejercicios 
  /*  $('select#learningobjectsSelected').on('change', function(){

        var oa_name = $('select#learningobjectsSelected option:selected').text();

        $.getJSON("../v1/exercises/" + oa_name, function (data) {
            var li = '';

            $('.upload-msg').append('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<strong>Alerta!</strong><p>Ejercicios existentes: ' +data.exercise + ' de 10 maximo</p></div>');
            window.setTimeout(function() {
                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });	}, 3000);
            // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
        }).done(function () {

        }).fail(function () {
           // alert('Sorry! Unable to fetch');
            $('.upload-msg').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
                '<strong>Alerta!</strong><p>Aun no se agrega contenido al OA</p></div>');
            window.setTimeout(function() {
                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });	}, 3000);
        }).always(function () {

        });

    });*/


});




/****************************************************************************************************
 *  LEARNING OBJECTS
 *****************************************************************************************************/

    //action for button addlearningobjects
    $('button#addOA').on('click', function () {

        //obtener variables de los campos de texto
        var title = $('input#inputNameOA').val();

        var language = "español";
        var language_id = $('select#languageSelected').prop("selectedIndex")+1;
        if (language_id==2)
            language = "ingles";

        var description = $('input#inputDescription').val();
        var version = $('input#inputVersion').val();
        var author = $('input#inputAutor').val();
        var image = "mn.jpg";
        var book_id =  $('select#bookSelected option:selected').val();
        var book_name = $('select#bookSelected option:selected').text();


        if (title && image && book_id && description && version && author)
        {
            $.post("../v1/learningobjects/add/",
                {learningobject_name: title, learningobject_image: image, book_id: book_id},
                function (data) {
                    if (!data.error) {
                        $('.upload-msg').append('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<strong>Message!</strong><p>' + data.message +'</p></div>');
                        window.setTimeout(function() {
                            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove();
                            });	}, 3000);
                        //var textoa = $('input#inputNameOA').val();
                        //var lev_id = $('select#levelSelectedoa').prop("selectedIndex")+1;
                        var li = '<li  class="btn btn-default btn-xs btn-block"><label>'+" "+title+' </label></li>';
                        $('#learningobjects').append(li);
                        $('#inputNameOA').val("");
                        $('#inputDescription').val("");
                        $('#inputAutor').val("");
                        $('#inputVersion').val("");


                        //assigCourse(data.student_id, c_id);
                    }else{
                       // alert(data.message);
                        $(".upload-msg").html(data.message);
                        window.setTimeout(function() {
                            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove();
                            });	}, 5000);
                    }
                }).done(function () {

            }).fail(function () {
                alert('Sorry! Internal error');
            }).always(function () {

            });

            $.post("../v1/learningobjects/createmetadata/",
                {learningobject_name: title, learningobject_idioma: language, learningobject_descripcion: description,
                    learningobject_version:version, learningobject_autor: author, book_name: book_name},
                function(data){
                    if (!data.error){

                    }else{
                       // alert(data.message);
                        $(".upload-msg").html(data.message);
                        window.setTimeout(function() {
                            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove();
                            });	}, 5000);
                    }
                }
        ).done(function () {

            }).fail(function () {
                alert('Sorry! Internal error in xml');
            }).always(function () {

            });

        }else{
            $('.upload-msg').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
                '<strong>Error!</strong><p>Empty fields</p></div>');
            window.setTimeout(function() {
                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });	}, 3000);
        }



    });


    //get learningObjects
    function getLearningobjects(id) {
        $.getJSON("../v1/learningObjects/", function (data) {
            var li = '';
            $.each(data.course, function (i, object) {
                if(id == object.book_id){
                    courses=
                        li += '<li  class="btn btn-default btn-xs btn-block"  OA_name='+object.learningobject_name+'><label>'+object.learningobject_name+' </label></li>';
                    //    '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Group: </label><span>'+" "+course.course_name+' </span></li>';

                }

            });
            $('ul#learningobjects').html(li);
            $('ul#learningobjects li').click(function() {
                $('ul#learningobjects li').removeClass('btn-primary');
            });
            // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
        }).done(function () {

        }).fail(function () {
            alert('Sorry! Unable to fetch');
        }).always(function () {

        });
    }


/****************************************************************************************************
 *  POST, GET TEMATICAS
 *****************************************************************************************************/

    //action for button addbooks
    $('button#addtematica').on('click', function () {

        //obtener variables de los campos de texto
        var title = $('input#inputTematica').val();
        var image = "mn.jpg";
        var level_id = 1;

        // var c_id = $('button#send').attr("course_id");
        if (title)
        {
            $.post("../v1/books/add/",
                {book_name: title, book_image: image, level_id: level_id},
                function (data) {
                    if (!data.error) {

                        $('#upload-tematica').append('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<strong>Message!</strong><p>' + data.message +'</p></div>');
                        window.setTimeout(function() {
                            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove();
                            });	}, 3000);

                        //var textoa = $('input#inputNameOA').val();
                        //var lev_id = $('select#levelSelectedoa').prop("selectedIndex")+1;
                       // var li = '<li  class="btn btn-default btn-lg btn-block"><label>'+title+' </label></li>';

                        getbooks();
                        $('#tematicas').append(li);
                        $('#inputTematica').val("");



                        //assigCourse(data.student_id, c_id);
                    }else{
                        $('#upload-tematica').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
                            '<strong>Error!</strong><p>' + data.message +'</p></div>');
                        window.setTimeout(function() {
                            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove();
                            });	}, 3000);

                    }
                }).done(function () {

            }).fail(function () {
                alert('Sorry! Internal error');
            }).always(function () {

            });

        }else{
            $('#upload-tematica').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
                '<strong>Error!</strong><p>Empty fields</p></div>');
            window.setTimeout(function() {
                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });	}, 3000);
        }
    });

/****************************************************************************************************
*  OBTENER TEMATICAS
*****************************************************************************************************/

    //get books
    function getbooks() {
        $.getJSON("../v1/books/", function (data) {
            var li = '';
            $.each(data.book, function (i, object) {
                courses=
                    li += '<li  class="btn btn-default btn-sm btn-block" data-toggle="tooltip" title="click para mostrar los OA" book_name='+object.book_name+' id='+object.book_id+'><h6>'+object.book_name+' </h6></li>';
                //    '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Group: </label><span>'+" "+course.course_name+' </span></li>';
            });
            $('ul#tematicas').html(li);
            $('ul#tematicas li').click(function() {
                $('ul#tematicas li').removeClass('btn-primary');
                $(this).addClass('btn-primary');
                // attaching the chatroom id to send button
                //  $('button#remove').attr('course_name', $(this).attr('course_name'));
                //  getMessages($(this).prop('id'));
                getLearningobjects($(this).prop('id'));
                /*$('button#optionAddStudent').removeClass("disabled");
                $('button#optionAddStudent').attr("data-target", ".addStudent");*/

            });

            // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
        }).done(function () {

        }).fail(function () {
            alert('Sorry! Unable to fetch topic messages');
        }).always(function () {

        });
    }

/****************************************************************************************************
 *   ADD EXERCISES
 *****************************************************************************************************/

    //action for button addlearningobjects
    $('button#addexercise').on('click', function () {

       // var title = $('input#inputNameExercise').val();
        var title = "null";
        var description = $('input#inputDescriptionExercise').val();
        var oa_name = $('select#learningobjectsSelected option:selected').text();
        var question = $('input#inputQuestion').val();

        var radio = $('input:radio[name=optradio]:checked').val();
        var answer1 = 0;
        var answer2 = 0;
        var answer3 = 0;
        var ok = 1;
        if(radio == 1){
            //obtener variables de los campos de texto

            answer1 = $('input#inputAnswer').val();
            answer1 = "["+answer1+"]";
            ok = 1;


            if (description && question && answer1)
            {
                $.post("../v1/learningObjects/addexercises/",
                    {learningobject: oa_name, exercise_name: title, exercise_type:radio, exercise_description: description,
                        exercise_question:question, exercise_answer1:answer1, exercise_answer2:answer2, exercise_answer3:answer3, exercise_ok:ok},
                    function (data) {
                        if (!data.error) {
                            $('#upload-exercise').append('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<strong>Message!</strong><p>' + data.message +'</p></div>');
                            window.setTimeout(function() {
                                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                    $(this).remove();
                                });	}, 3000);
                            /* var li = '<li  class="btn btn-default btn-xs btn-block"><label>'+" "+title+' </label></li>';
                             $('#learningobjects').append(li);*/
                            $('#inputNameExercise').val("");
                            $('#inputDescriptionExercise').val("");
                            $('#inputQuestion').val("");
                            $('#inputAnswer').val("");


                            //assigCourse(data.student_id, c_id);
                        }else{
                            $('#upload-exercise').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
                                '<strong>Message!</strong><p>' + data.message +'</p></div>');
                            window.setTimeout(function() {
                                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                    $(this).remove();
                                });	}, 3000);
                        }
                    }).done(function () {

                }).fail(function () {
                    alert('Sorry! Internal error');
                }).always(function () {

                });


            }else{
                $('#upload-exercise').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
                    '<strong>Error!</strong><p>Empty fields</p></div>');
                window.setTimeout(function() {
                    $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove();
                    });	}, 3000);
            }


        }else {//click en opcion multiple


            answer1 = $('input#inputAnswer1').val();
            answer2 = $('input#inputAnswer2').val();
            answer3 = $('input#inputAnswer3').val();
            ok = $('input:radio[name=ansradio]:checked').val();

            if (description && question && answer1 && answer2 && answer3)
            {
                $.post("../v1/learningObjects/addexercises/",
                    {learningobject: oa_name, exercise_type:radio, exercise_name: title, exercise_description: description,
                        exercise_question:question, exercise_answer1:answer1, exercise_answer2:answer2, exercise_answer3:answer3, exercise_ok:ok},
                    function (data) {
                        if (!data.error) {
                            $('#upload-exercise').append('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<strong>Message!</strong><p>' + data.message +'</p></div>');
                            window.setTimeout(function() {
                                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                    $(this).remove();
                                });	}, 3000);
                            /* var li = '<li  class="btn btn-default btn-xs btn-block"><label>'+" "+title+' </label></li>';
                             $('#learningobjects').append(li);*/
                            $('#inputNameExercise').val("");
                            $('#inputDescriptionExercise').val("");
                            $('#inputQuestion').val("");
                            $('#inputAnswer1').val("");
                            $('#inputAnswer2').val("");
                            $('#inputAnswer3').val("");
                            $("#answer1").attr('checked', true);


                            //assigCourse(data.student_id, c_id);
                        }else{

                            $('#upload-exercise').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
                                '<strong>Message!</strong><p>' + data.message +'</p></div>');
                            window.setTimeout(function() {
                                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                    $(this).remove();
                                });	}, 3000);                        }
                    }).done(function () {

                }).fail(function () {
                    alert('Sorry! Internal error');
                }).always(function () {

                });


            }else{
                $('#upload-exercise').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
                    '<strong>Error!</strong><p>Empty fields</p></div>');
                window.setTimeout(function() {
                    $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove();
                    });	}, 3000);            }

        }

    });





/****************************************************************************************************
 *  EVENTOS DE LOS MODALS
 *****************************************************************************************************/

/*evento los modals estan visibles*/
$('#addexercise').on('show.bs.modal', function () {

    $('#multipleoption').hide(); //oculto mediante id
    $("#buttoncuestionary").attr('checked', true);
    $('#answer1').attr('checked', true);

    //obtener los objetos de aprendizaje de la base de datos
    $.getJSON("../v1/learningObjects/", function (data) {
        var li = '';
        $.each(data.course, function (i, object) {

            courses=
                li += '<option  value='+object.learningobject_name+'>'+object.learningobject_name+'</option>';
            //    '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Group: </label><span>'+" "+course.course_name+' </span></li>';

        });
        $('select#learningobjectsSelected').html(li);

        // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
    }).done(function () {

    }).fail(function () {
        alert('Sorry! Unable to fetch');
    }).always(function () {

    });

});

/*evento los modals estan visibles*/
$('#addObjectlearning').on('show.bs.modal', function () {

    $.getJSON("../v1/books/", function (data) {
        var li = '';
        $.each(data.book, function (i, object) {
            courses=
                li += '<option  value='+object.book_id+'>'+object.book_name+'</option>';
            //    '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Group: </label><span>'+" "+course.course_name+' </span></li>';

        });
        $('select#bookSelected').html(li);

        // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
    }).done(function () {

    }).fail(function () {
        alert('Sorry! Unable to fetch topic messages');
    }).always(function () {

    });


});

/*evento los modals estan visibles*/
$('#addresource').on('show.bs.modal', function () {

    $.getJSON("../v1/learningObjects/", function (data) {
        var li = '';
        $.each(data.course, function (i, object) {

            courses=
                li += '<option  value='+object.learningobject_name+'>'+object.learningobject_name+'</option>';
            //    '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Group: </label><span>'+" "+course.course_name+' </span></li>';


        });
        $('select#learningobjectsResource').html(li);

        // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
    }).done(function () {

    }).fail(function () {
        alert('Sorry! Unable to fetch');
    }).always(function () {

    });


});


//funcion AJAX para subir archivos a servidor
function upload_image(){//Funcion encargada de enviar el archivo via AJAX
    $(".upload-msg").text('Cargando...');
    var inputFileImage = document.getElementById("fileToUpload");
    var file = inputFileImage.files[0];
    var data = new FormData();
    var filename = $('input[type=file]').val().split('\\').pop();
    var oa_name = $('select#learningobjectsResource option:selected').text();
    data.append('fileToUpload',file);
    data.append('oa_name', oa_name);

    var oktype = $('input:radio[name=typeradio]:checked').val();
    /*jQuery.each($('#fileToUpload')[0].files, function(i, file) {
     data.append('file'+i, file);
     });*/

    $.ajax({
        url: "upload.php",        // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(data)   // A function to be called if request succeeds
        {


            $.post("../v1/learningObjects/addresources/",
                {learningobject: oa_name, exercise_type: oktype, exercise_description: filename},
                function (data2) {
                    if (!data2.error) {

                       /* $('.upload-msg').append('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<strong>Message!</strong><p>' + data.message +'</p></div>');
                        window.setTimeout(function() {
                            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove();
                            });	}, 3000);*/

                       $(".upload-msg").html(data);
                        $('.upload-msg').append('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<strong>Message!</strong><p>' + data2.message +'</p></div>');
                        window.setTimeout(function() {
                            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove();
                            });	}, 5000);


                        //assigCourse(data.student_id, c_id);
                    }else{
                        $('.upload-msg').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
                            '<strong>Error!</strong><p>' + data2.message +'</p></div>');
                        window.setTimeout(function() {
                            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove();
                            });	}, 3000);

                    }
                }).done(function () {

            }).fail(function () {
                alert('Sorry! Internal error');
            }).always(function () {

            });

        }
    });

}


//codigo para click boton regresar a panel
$('button#optionreturn').on('click',function(){
    window.open("/../ciex/panel.php","_self");
});



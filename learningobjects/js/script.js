/*// DOM manipulation
 // console.log(document.getElementById("title"));
 // console.log(document instanceof HTMLDocument);*/
var eliminar_pk="0";

$(document).ready(function(){


    $('#tematicaContent').hide(); //muestro mediante id
    $('#oaContent').hide(); //muestro mediante id
    $('#oaContentexercise').hide(); //muestro mediante id



    //codigo de boton para abir /ciex/learningobjects/index.php
    $('#home').on('click',function(){
        window.open("index.php","_self");
    });
    $('#optionn').on('click',function(){
        window.open("index.php","_self");
    });


    $("#optionp0").on( "click", function() {
        $('#oaHome').hide();
        $('#tematicaContent').show();
        $('#oaContent').hide(); //
        $('#oaContentexercise').hide(); //
        $('button#optionp1').removeClass('btn-primary');
        $('button#optionp0').addClass('btn-primary');
        $('button#optionp2').removeClass('btn-primary');

        $('button#optionr1').addClass('invisible');
        $('button#optione1').addClass('invisible');
        getbooks();//obtener todas las temáticas
    });

    $("#optionn0").on( "click", function() {
        $('#oaHome').hide();
        $('#tematicaContent').show();
        $('#oaContent').hide(); //
        $('#oaContentexercise').hide(); //
        $('button#optionp1').removeClass('btn-primary');
        $('button#optionp0').addClass('btn-primary');
        $('button#optionp2').removeClass('btn-primary');

        $('button#optionr1').addClass('invisible');
        $('button#optione1').addClass('invisible');
        getbooks();//obtener todas las temáticas
    });

    $("#optionp1").on( "click", function() {
        $('#oaHome').hide();
        $('#tematicaContent').hide();
        $('#oaContent').show(); //
        $('#oaContentexercise').hide(); //
        $('button#optionp0').removeClass('btn-primary');
        $('button#optionp1').addClass('btn-primary');
        $('button#optionp2').removeClass('btn-primary');


        getbooks();//obtener todas las temáticas
    });

    $("#optionn1").on( "click", function() {
        $('#oaHome').hide();
        $('#tematicaContent').hide();
        $('#oaContent').show(); //
        $('#oaContentexercise').hide(); //
        $('button#optionp0').removeClass('btn-primary');
        $('button#optionp1').addClass('btn-primary');
        $('button#optionp2').removeClass('btn-primary');


        getbooks();//obtener todas las temáticas
    });

    $("#optionp2").on( "click", function() {
        $('#oaHome').hide();
        $('#tematicaContent').hide();
        $('#oaContent').hide(); //
        $('#oaContentexercise').show(); //
        $('button#optionp0').removeClass('btn-primary');
        $('button#optionp1').removeClass('btn-primary');
        $('button#optionp2').addClass('btn-primary');

        getallbooks();
        var book_id = $('select#bookexerciseSelect').val();

        $('button#option7').addClass('invisible');
        $('button#option8').addClass('invisible');

    });

    $("#optionn2").on( "click", function() {
        $('#oaHome').hide();
        $('#tematicaContent').hide();
        $('#oaContent').hide(); //
        $('#oaContentexercise').show(); //
        $('button#optionp0').removeClass('btn-primary');
        $('button#optionp1').removeClass('btn-primary');
        $('button#optionp2').addClass('btn-primary');

        getallbooks();
        var book_id = $('select#bookexerciseSelect').val();

        $('button#option7').addClass('invisible');
        $('button#option8').addClass('invisible');

    });



    $("#buttoncuestionary").on( "click", function() {
        $('#cuestionary').show(); //muestro mediante id
        $('#multipleoption').hide(); //muestro mediante id
        // $('.target').show(); //muestro mediante clase
    });

    $("#buttonoptions").on( "click", function() {
        $('#cuestionary').hide(); //oculto mediante id
        $('#multipleoption').show(); //mostrar mediante id

        //  $('.target').hide(); //muestro mediante clase
    });





});




/****************************************************************************************************
 * ADD LEARNING OBJECTS
 ****************************************************************************************************/

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

    var image = "default";
    var image_id = $('select#typeSelected').prop("selectedIndex")+1;
    if (image_id==2)
        image = "videoquiz";

    //var book_id =  $('select#bookSelected option:selected').val();
    var book_id =  $('select#tematicasSelected option:selected').val();
    var book_name = $('select#tematicasSelected option:selected').text();
    //var book_name = $('select#bookSelected option:selected').text();


    if (title && image && book_id && description && version && author)
    {
        $.post("../v1/learningobjects/add/",
            {learningobject_name: title, learningobject_image: image, book_id: book_id, learningobject_idioma: language, learningobject_descripcion: description,
                learningobject_version:version, learningobject_author: author, book_name: book_name},
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
                    /*var li = '<li  class="btn btn-default btn-xs btn-block"><label>'+" "+title+' </label></li>';
                     $('#learningobjects').append(li);
                     $('ul#learningobjects li').click(function() {
                     $('ul#learningobjects li').removeClass('btn-success');
                     $(this).addClass('btn-success');
                     $('button#option2').removeClass('disabled');
                     $('button#option4').removeClass('disabled');
                     });*/
                    getLearningobjects(book_id);

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
            alert('Disculpa, se detecto un error interno');
        }).always(function () {

        });

    }else{
        $('.upload-msg').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
            '<strong>Advertencia!</strong><p>No se puede crear un OA sin datos</p></div>');
        window.setTimeout(function() {
            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });	}, 3000);
    }

});

/****************************************************************************************************
 * GET LEARNING OBJECTS
 *****************************************************************************************************/

//get learningObjects
function getLearningobjects(id) {
    $.getJSON("../v1/learningObjects/", function (data) {
        var li = '';
        var li2 ='';
        var cont = 0;
        $.each(data.course, function (i, object) {
            if(id == object.book_id){
                courses=
                    cont = cont + 1;
                //  li += '<li  class="list-group-item"  OA_name='+object.learningobject_name + '><label>'+object.learningobject_name+' </label></li>';
                // li  += '<li  class="list-group-item text-left"  data-toggle="" title=""' + 'OA_name='+ object.learningobject_name +  'id=' + object.book_id+'><h5>'+ object.learningobject_name  + ' </h5><button class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>Eliminar</button></li>';

                li  += '<li  class="btn btn-default btn-xs btn-block "  data-toggle="tooltip" title=""' + 'OA_name=' + object.learningobject_name + ' id=' + object.learningobject_id+'>' +
                    '<h5 align="left">'+'Título: '+object.learningobject_name+ ' Tipo: '+object.learningobject_type+ ' </h5></li>';

                /* lix += '<li class="margin_e"><button class="btn btn-danger" data-toggle="modal" data-target= "#dataDeleteoa" data-id='+ object.book_id +' >' +
                 '<i class="glyphicon glyphicon-trash"></i></button><button class="btn btn-info" data-toggle="modal" data-target= "#dataDeleteoa" data-id='+ object.book_id +'>' +
                 '<i class="glyphicon glyphicon-edit"></i></button></li>';*/

                li2 += '<option  value='+ object.learningobject_type  +' name ='+ object.learningobject_name + '>'+ object.learningobject_name+'</option>';
                //    '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Group: </label><span>'+" "+course.course_name+' </span></li>';

                if (cont ==1){
                    if (object.learningobject_type == "default"){
                        $('button#option2').removeClass('invisible');
                        $('button#option4').removeClass('invisible');
                        $('button#option5').addClass('invisible');
                        $('button#option6').addClass('invisible');
                        getallexercises(object.learningobject_name);
                    }else{
                        $('button#option2').addClass('invisible');
                        $('button#option4').addClass('invisible');
                        $('button#option5').removeClass('invisible');
                        $('button#option6').removeClass('invisible');
                        getallexercises(object.learningobject_name);

                    }
                }
            }

        });
        $('ul#learningobjects').html(li);
        $('ul#learningobjects li').click(function() {
            $('ul#learningobjects li').removeClass('btn-press');
            $(this).addClass('btn-press');

            $('#optione2').removeClass('invisible');
            $('#optionr2').removeClass('invisible');

            $('button#optionr2').attr('id_oa', $(this).attr('id'));
            $('button#optionr2').attr('name_oa', $(this).attr('OA_name'));


        });
        $('select#oaexerciseSelect').html(li2);
        $('select#oaexerciseSelect').on('click', function () {
            var select = $('select#oaexerciseSelect option:selected').text();
            // var select = $(this).text();
            var type = $(this).val();
            if (select =="")
                alert("elemento vacio");
            else{
                $('button#option7').addClass('invisible');
                $('button#option8').addClass('invisible');
                if (type == "default"){
                    $('button#option2').removeClass('invisible');
                    $('button#option4').removeClass('invisible');
                    $('button#option5').addClass('invisible');
                    $('button#option6').addClass('invisible');
                    getallexercises(select);

                }else{
                    $('button#option2').addClass('invisible');
                    $('button#option4').addClass('invisible');
                    $('button#option5').removeClass('invisible');
                    $('button#option6').removeClass('invisible');
                    getallexercises(select);
                }

            }

        });
        // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
    }).done(function () {

    }).fail(function () {
        alert('Sorry! Unable to fetch');
    }).always(function () {

    });
}


/****************************************************************************************************
 *  POST TEMATICAS
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
                    $('#inputTematica').val("");
                    getbooks();
                    $('#tematicas').append(li);

                    $('button#optionr1').addClass('invisible');
                    $('button#optione1').addClass('invisible');


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
        var li2 = '';
        var cont = 0;
        var one_id = 0;

        $.each(data.book, function (i, object) {
            courses=
                cont = cont +1;
            li  += '<li  class="btn btn-block btn-xs btn-default"  data-toggle="tooltip" title=""' + 'book_name=' + object.book_name + ' id=' + object.book_id+'>' +
                '<h5 align="left">'+object.book_name+' </h5></li>';

            /* lix += '<li class="margin_e"><button class="btn btn-danger btn-md" data-toggle="modal" data-target= "#dataDelete" data-id='+ object.book_id +'>' +
             '<i class="glyphicon glyphicon-trash"></i></button><button class="btn btn-info btn-md" data-toggle="modal" data-target= "#dataDelete" data-id='+ object.book_id +'>' +
             '<i class="glyphicon glyphicon-edit"></i></button></li>';
             */

            // li2 += '<li class="btn btn-default btn-xs btn-block"  data-toggle="tooltip" title="click para mostrar los OA"' + 'book_name=' + object.book_name + ' id=' + object.book_id+'><h6>'+object.book_name+' </h6></li>';
            li2 += '<option  value=' + object.book_id + ' id=' + object.book_id   +' name ='+ object.book_name + '>'+ object.book_name+'</option>';

            if(cont==1)
                getLearningobjects(object.book_id);
            /*    '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Group: </label><span>'+" "+course.course_name+' </span></li>';*/

        });
        $('ul#tematicas').html(li);

        $('ul#tematicas li ').click(function() {

            $('button#optionr1').attr('id_book', $(this).attr('id'));
            $('button#optionr1').attr('name_book', $(this).text());
            $('button#optione1').removeClass('invisible');
            $('button#optionr1').removeClass('invisible');

            $('ul#tematicas li ').removeClass('btn-press');
            $(this).addClass('btn-press');
        });

        $('select#tematicasSelected').html(li2);
        $('select#tematicasSelected').on('click', function () {
            var select = $('select#tematicasSelected option:selected').attr('id');
            $('button#optione2').addClass('invisible');
            $('button#optionr2').addClass('invisible');
            getLearningobjects(select);

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

    var select = $('select#oaexerciseSelect option:selected').text();
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

                        getallexercises(select);
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

                        getallexercises(select);

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
                });	}, 3000);
        }

    }

});


/****************************************************************************************************
 *  GET  EXERCISES
 *****************************************************************************************************/

//get exercise
function getallexercises(id) {
    var li = '';
    var li2 = '';
    var lix = '';

    $.getJSON("../v1/exercises/"+id, function (data) {
        if (!data.error) {

            $.each(data.exercise, function (i, object) {
                courses=
                    // alert(object.exercise_type)  ;
                    li  += '<li  class=" btn btn-default btn-block btn-xs"  data-toggle="tooltip" title=""' + ' id=' + object.exercise_type+'>' +
                        '<h5 align="left">'+ object.exercise_type + ' '+ object.exercise_id+' </h5></li>';


            });

            $('ul#exercises').html(li);
            $('ul#exercises li').on('click', function () {
                $('ul#exercises li').removeClass('btn-press');
                $(this).addClass('btn-press');

                // var select = $(this).text();
                var select = $(this).prop('id');
                $('button#option7').attr('value', select);
                $('button#option7').removeClass('invisible');
                $('button#option8').removeClass('invisible');



            });
            //    $('ul#exer').html(lix);

        }else{

        }

        // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
    }).done(function () {

    }).fail(function () {
        $('#upload-exercise').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
            '<strong>Message!</strong><p>' + 'Sorry! Unable to fetch topic messages'+'</p></div>');
        window.setTimeout(function() {
            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });	}, 3000);

    }).always(function () {

    });
}

$('#option7').on('click', function () {
    alert($(this).attr('value'));
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
                li += '<option  value='+object.learningobject_name+'>'+ object.learningobject_name+'</option>';
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

    $('h5#exampleSelect1').text($('select#tematicasSelected option:selected').text());



});

/*evento los modals estan visibles*/
$('#addresource').on('show.bs.modal', function () {

    $.getJSON("../v1/learningObjects/", function (data) {
        var li = '';
        $.each(data.course, function (i, object) {

            courses=
                li += '<option  value='+object.learningobject_name+'>'+ object.learningobject_name +'</option>';
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


$( "#formDeleteTematica" ).on('show.bs.modal',function(  ) {
    $('button#deleteok1').attr('pk',$('button#optionr1').attr('id_book'));
    $('h5#textModal1').text('Esta acción eliminará la temática :'+ $('button#optionr1').attr('name_book'));
});


$( "#formDeleteOa" ).on('show.bs.modal',function(  ) {

    $('button#deleteok2').attr('pk',$('button#optionr2').attr('id_oa'));
    // $('button#deleteok2').text($('button#optionr2').attr('id_oa'));

    $('h5#textModal2').text('Esta acción eliminará el OA de nombre : '+ $('button#optionr2').attr('name_oa'));
});


/****************************************************************************************************
 *  OTRAS FUNCIONES
 *****************************************************************************************************/

//funciones independientes
function getallbooks() {
    $.getJSON("../v1/books/", function (data) {
        var li = '';
        var li0 = '';
        var cont =0;


        $.each(data.book, function (i, object) {
            courses=
                cont = cont+1;
            li += '<option  value='+object.book_id +'>'+object.book_name+'</option>';
            //    '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Group: </label><span>'+" "+course.course_name+' </span></li>';
            if (cont== 1)
                getLearningobjects(object.book_id);

        });
        $('select#bookexerciseSelect').html(li);
        $('select#bookexerciseSelect').click(function() {
            //alert($(this).val());
            getLearningobjects($('select#bookexerciseSelect option:selected').val());
            $('#option7').addClass('invisible');
            $('#option8').addClass('invisible');

        });

        // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
    }).done(function () {

    }).fail(function () {
        alert('Sorry! Unable to fetch topic messages');
    }).always(function () {

    });

}



$('button#optionr1').on('click', function () {

    var select = $(this).attr('pk');

    $.post("../v1/books/delete/",
        {id_tematica: select},
        function (data) {
            //alert(data.message);
            $('#remove-tematica').append('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<strong>Message!</strong><p>' + data.message +'</p></div>');
            window.setTimeout(function() {
                $(".alert-dismissible").fadeTo(2000, 0).slideUp(500, function()
                { $(this).remove();});
            }, 3000);



            if(!data.error){
                getbooks();
                $('button#optionr1').addClass('invisible');
                $('button#optione1').addClass('invisible');
            }
        }).done(function () {

    }).fail(function () {
        // alert('Sorry! Internal error');
        $('#remove-tematica').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
            '<strong>Message!</strong><p>' + 'Lo sentimos el sistema experimento un error, intente nuevamente' +'</p></div>');
        window.setTimeout(function() {
            $(".alert-dismissible").fadeTo(2000, 0).slideUp(500, function(){
                $(this).remove();
            });	}, 3000);
    }).always(function () {

    });

});

$('button#optionr2').on('click', function () {

    var select = $(this).attr('pk');
    var id_tematica = $('select#tematicasSelected option:selected').text();


    $.post("../v1/learningobjects/delete/",
        {id_oa: select, name_tematica: id_tematica},
        function (data) {
            //alert(data.message);
            $('#remove-oa').append('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<strong>Message!</strong><p>' + data.message +'</p></div>');
            window.setTimeout(function() {
                $(".alert-dismissible").fadeTo(2000, 0).slideUp(500, function()
                { $(this).remove();});
            }, 3000);



            if(!data.error){
                getbooks();
                getLearningobjects(select);
                $('button#optionr1').addClass('invisible');
                $('button#optione1').addClass('invisible');
            }
        }).done(function () {

    }).fail(function () {
        // alert('Sorry! Internal error');
        $('#remove-oa').append('<div class="alert alert-danger alert-dismissible" role="alert">' +
            '<strong>Message!</strong><p>' + 'Lo sentimos el sistema experimento un error, intente nuevamente' +'</p></div>');
        window.setTimeout(function() {
            $(".alert-dismissible").fadeTo(2000, 0).slideUp(500, function(){
                $(this).remove();
            });	}, 3000);
    }).always(function () {

    });

});


$('#dataDelete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que activó el modal
    var id = button.data('id'); // Extraer la información de atributos de datos
    var modal = $(this);
    modal.find('#id_tematica').val(id)
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
    window.open("/../miidt/panel.php","_self");
});


//codigo para click boton regresar a panel
$('button#optionreturn2').on('click',function(){
    window.open("/../miidt/panel.php","_self");
});
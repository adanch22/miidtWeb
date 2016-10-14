/*// DOM manipulation
// console.log(document.getElementById("title"));
// console.log(document instanceof HTMLDocument);*/

$(document).ready(function(){

    getLearningobjects();

//action for button ADDLEARNINGOBJECTS
    $('button#addOA').on('click', function () {
        var titulo = $('input#inputNameOA').val();
        var imagen = "x.jpg";
        var book_id = 1;
       // var lev_id = $('select#levelSelectedoa').prop("selectedIndex")+1;

       // var c_id = $('button#send').attr("course_id");
        if (titulo && imagen && book_id) {
            $.post("../v1/learningobjects/add/",
                {learningobject_name: titulo, learningobject_image: imagen, book_id: book_id},
                function (data) {
                    if (!data.error) {
                        var textoa = $('input#inputNameOA').val();
                        var lev_id = $('select#levelSelectedoa').prop("selectedIndex")+1;
                        var li = '<li  class="btn btn-default btn-xs btn-block"><label>'+" "+titulo+' </label></li>';

                        $('#learningobjects').append(li);
                        $('#inputNameOA').val("");

                        //assigCourse(data.student_id, c_id);
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


    //get courses
    function getLearningobjects() {
        $.getJSON("../v1/learningObjects/", function (data) {
            var li = '';
            $.each(data.course, function (i, object) {
                courses=
                    li += '<li  class="btn btn-default btn-xs btn-block" course_name='+object.learningobject_name+'><label>'+" "+object.learningobject_name+' </label></li>';
                    //    '<li  class="btn btn-default btn-block" course_name='+course.course_name+' id='+course.course_id+'><label>Group: </label><span>'+" "+course.course_name+' </span></li>';
            });
            $('ul#learningobjects').html(li);
            $('ul#learningobjects li').click(function() {
                $('ul#courses li').removeClass('btn-primary');
            });
            // $('#scrollMsj').scrollTop($('#scrollMsj').prop("scrollHeight"));
        }).done(function () {

        }).fail(function () {
            alert('Sorry! Unable to fetch topic messages');
        }).always(function () {

        });
    }


});


//codigo para click boton regresar a panel
$('button#option4').on('click',function(){
    window.open("/../ciex/panel.php","_self");
});

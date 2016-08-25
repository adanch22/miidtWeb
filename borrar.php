<?php
/**
 * Created by PhpStorm.
 * User: azulyoro
 * Date: 11/04/16
 * Time: 6:11 PM
 */
error_reporting(-1);
ini_set('display_errors', 'On');
?>

<?php
require_once __DIR__ . '/adminpanel.php';
$demo = new panel();
$admin_id = $demo->getDemoUser();
?>

<html>
<head>
    <title>CIEX v0.1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,800,100' rel='stylesheet' type='text/css'>
    <link href='style.css' rel='stylesheet' type='text/css'>
    <link href='http://api.androidhive.info/gcm/styles/default.css' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script type="text/javascript">
        var user_id = '<?= $admin_id ?>';

        $(document).ready(function () {

            getChatroomMessages($('#topics li:first').attr('id'));

            $('ul#topics li').on('click', function () {
                $('ul#topics li').removeClass('selected');
                $(this).addClass('selected');
                getChatroomMessages($(this).prop('id'))
            });


            function getChatroomMessages(id) {
                $.getJSON("v1/chat_rooms/" + id, function (data) {
                    var li = '';
                    $.each(data.messages, function (i, message) {
                        li += '<li class="others"><label class="name">' + message.user.username + '</label><div class="message">' + message.message + '</div><div class="clear"></div></li>';
                    });
                    $('ul#topic_messages').html(li);
                    if (data.messages.length > 0) {
                        scrollToBottom('msg_container_topic');
                    }
                }).done(function () {

                }).fail(function () {
                    alert('Sorry! Unable to fetch topic messages');
                }).always(function () {

                });

                // attaching the chatroom id to send button
                $('#send_to_topic').attr('chat_room', id);
            }

            $('#send_to_topic').on('click', function () {

                var msg = $('#send_to_topic_message').val();

                if (msg.trim().length === 0) {
                    alert('Enter a message');
                    return;
                }

                $('#send_to_topic_message').val('');
                $('#loader_topic').show();

                $.post("v1/chat_rooms/" + $(this).attr('chat_room') + '/message',
                    {user_id: user_id, message: msg},

                    function (data) {
                        if (data.error === false) {
                            var li = '<li class="others"><label class="name">' + data.user.name + '</label><div class="message">' + data.message.message + '</div><div class="clear"></div></li>';
                            $('ul#topic_messages').append(li);
                            scrollToBottom('msg_container_topic');
                        } else {
                            alert('Sorry! Unable to send message');
                        }
                    }).done(function () {

                }).fail(function () {
                    alert('Sorry! Unable to send message');
                }).always(function () {
                    $('#loader_topic').hide();
                });
            });

            $('input#send_to_single_user').on('click', function () {
                var msg = $('#send_to_single').val();
                var to = $('.select_single').val();
                if (msg.trim().length === 0) {
                    alert('Enter a message');
                    return;
                }

                $('#send_to_single').val('');
                $('#loader_single').show();

                $.post("v1/users/" + to + '/message',
                    {user_id: user_id, message: msg},
                    function (data) {
                        console.log(data);
                        if (data.error === false) {
                            $('#loader_single').hide();
                            alert('Push notification sent successfully! You should see a Toast message on device.');
                        } else {
                            alert('Sorry! Unable to post message');
                        }
                    }).done(function () {

                }).fail(function () {
                    alert('Sorry! Unable to send message');
                }).always(function () {
                    $('#loader_single').hide();
                });
            });

            $('input#send_to_multiple_users').on('click', function () {
                var msg = $('#send_to_multiple').val();
                var to = $('.select_multiple').val();

                if (to === null) {
                    alert("Please select the users!");
                    return;
                }

                if (msg.trim().length === 0) {
                    alert('Enter a message');
                    return;
                }

                $('#send_to_multiple').val('');
                $('#loader_multiple').show();

                var selMulti = $.map($(".select_multiple option:selected"), function (el, i) {
                    return $(el).val();
                });

                to = selMulti.join(",");

                $.post("v1/users/message",
                    {user_id: user_id, to: to, message: msg},
                    function (data) {
                        if (data.error === false) {
                            $('#loader_multiple').hide();
                            alert('Push notification sent successfully to multiple users');
                        } else {
                            alert('Sorry! Unable to send message');
                        }
                    }).done(function () {

                }).fail(function () {
                    alert('Sorry! Unable to send message');
                }).always(function () {
                    $('#loader_multiple').hide();
                });
            });

            $('input#send_to_multiple_users_with_image').on('click', function () {

                var msg = $('#send_to_multiple_with_image').val();
                if (msg.trim().length === 0) {
                    alert('Enter a message');
                    return;
                }

                $('#send_to_multiple_with_image').val('');
                $('#loader_multiple_with_image').show();

                $.post("v1/users/send_to_all",
                    {user_id: user_id, message: msg},
                    function (data) {
                        if (data.error === false) {
                            $('#loader_multiple_with_image').hide();
                            alert('Push notification sent successfully to multiple users');
                        } else {
                            alert('Sorry! Unable to send message');
                        }
                    }).done(function () {

                }).fail(function () {
                    alert('Sorry! Unable to send message');
                }).always(function () {
                    $('#loader_topic_with_image').hide();
                });
            });

            function scrollToBottom(cls) {
                $('.' + cls).scrollTop($('.' + cls + ' ul li').last().position().top + $('.' + cls + ' ul li').last().height());
            }
        });
    </script>
</head>
<body>
<div class="header ">
    <div class="content">
        <img class="imagen" src="logo.png" alt="Norway" width="145" height="145">
        <div class="panel">
            <h2 class="blink">Admin panel</h2>
        </div>
    </div>
</div>
<div class="container_body">
    <div class="topics">
        <div class="box" >
            <div class="usr_container">
                <ul id="topics">
                    <?php
                    $chatrooms = $demo->getAllClassRooms();
                    foreach ($chatrooms as $key => $chatroom) {
                        $cls = $key == 0 ? 'selected' : '';
                        ?>
                        <li id="<?= $chatroom['chat_room_id'] ?>" class="<?= $cls ?>">
                            <label><?= $chatroom['name'] ?></label>
                            <span>group_<?= $chatroom['chat_room_id'] ?></span>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="msg_container msg_container_topic">
                <ul id="topic_messages"></ul>
            </div>

            <div class="send_container">
                <textarea placeholder="Type a message here" id="send_to_topic_message"></textarea>
                <input id="send_to_topic" type="button" value="Send"/>
                <img src="loader.gif" id="loader_topic" class="loader"/>
            </div>

            <div class="tools_container">
                <style>
                    a:link,
                    a:visited,
                    a:hover,
                    a:active {
                        text-decoration: none;
                        padding: 20px 20px 6px 20px;

                    }
                </style>
                <a class="caja" href="">Add new user</a>
                <div class="line"></div>
                <a href="">Remove a user</a>
                <div class="line"></div>
                <a href="">Add new group</a>
                <div class="line"></div>
                <a href="">Remove a group</a>
                <div class="line"></div>
                <a href="">help!</a>
                <div class="line"></div>
            </divcl>
        </div>
    </div>
</div>
</body>
</html>
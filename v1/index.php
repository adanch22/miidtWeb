<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../include/db_handler.php';
require_once '../include/PassHash.php';
require_once '../include/parseXML.php';

require '.././libs/vendor/slim/slim/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

            /*          admin         */

/***************************************************
 *  Resgister admin
 *  use this url to register new admin
 ***************************************************/
$app->post('/admin/register/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('admin_name', 'password','is_teacher'));

    $response = array();

    // reading post params
    $user_name = $app->request->post('admin_name');
    $password = $app->request->post('password');
    $is_teacher = $app->request->post('is_teacher');

    $db = new DbHandler();
        $res = $db->createAdmin($user_name, $password, $is_teacher);
        if ($res == CREATED_SUCCESSFULLY) {
            $response["error"] = false;
            $response["message"] = "Admin successfully registered";
            echoRespnse(201, $response);
        } else if ($res == CREATE_FAILED) {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred while registering";
            echoRespnse(200, $response);
        } else if ($res == ALREADY_EXISTED){
            $response["error"] = true;
            $response["message"] = "Teacher Already existed";
            echoRespnse(200, $response);
        }
});

/***************************************************
 *  Login admin
 *  use this url to login an admin
 ***************************************************/
$app->post('/admin/login/', function() use ($app) {

    // check for required params
    verifyRequiredParams(array('admin_name', 'password'));

    // reading post params
    $admin_name = $app->request()->post('admin_name');
    $password = $app->request()->post('password');

    $response = array();
    $db = new DbHandler();
    // check for correct user_tag and password
    if ($db->checkLoginAdmin($admin_name, $password)) {
        $response['error'] = false;
        $response['message'] = "user login!";
        session_start();
        $_SESSION['admin_name'] = $admin_name;
    } else {
        // user credentials are wrong
        $response['error'] = true;
        $response['message'] = 'Login failed. Incorrect credentials';
        echo "<script>alert('Login failed. Incorrect credentials');</script>";
    }
    echo "<script>window.open(\"../../index.php\",\"_self\");</script>";
});

/***************************************************
 *  Get admins
 *  use this url to get admin by id
 ***************************************************/
$app->get('/admin/type/:adm_id', function($admin_id) {
    $response = array();
    $db = new DbHandler();
    $result = $db->isTeacher($admin_id);
    $isTeacher = $result->fetch_assoc();
    echoRespnse(200, $isTeacher);
});

/***************************************************
 *  search admin "teachers"
 *  use this url to search teachers
 ***************************************************/
$app->post('/admin/teacher/search/', function() use($app) {
    // check for required params
    verifyRequiredParams(array('admin_name'));

    // reading post params
    $admin_name = $app->request()->post('admin_name');

    $response = array();
    $db = new DbHandler();

    // fetching all user tasks
    $result = $db->searchTeachers('%'.$admin_name.'%');

    $response["error"] = false;
    $response["admin"] = array();

    // pushing single chat room into array
    $flag=0;
    while ($user = $result->fetch_assoc()) {
        array_push($response["admin"], $user);
    }
    echoRespnse(200, $response);
});

            /*          courses         */

/***************************************************
 *  Add course
 *  use this url to add new classroom
 ***************************************************/
$app->post('/course/add', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('course_name','level_id'));

    $response = array();

    // reading post params
    $course_name = $app->request->post('course_name');
    $level_id = $app->request->post('level_id');
    $db = new DbHandler();
    $res = $db->addCourse("course_id", "courses", "course_name", $course_name, $level_id);
    if ($res['result'] == CREATED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "Course successfully registered";
        $response["course_id"] = $res['course_id'];
        echoRespnse(201, $response);
    } else if ($res['result'] == CREATE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        echoRespnse(200, $response);
    } else if ($res['result'] == ALREADY_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this course already existed";
        echoRespnse(200, $response);
    }
});

/***************************************************
 *  Get courses
 *  use this url to get courses
 ***************************************************/
$app->get('/courses/:adm_id', function($admin_id) {
    $response = array();
    $db = new DbHandler();
    $result = $db->isTeacher($admin_id);
    $isTeacher = $result->fetch_assoc();

    if($isTeacher["is_teacher"]){
        $result = $db->getSomeCourses($admin_id);
    }else{
        // fetching all user tasks
        $result = $db->getAllCourses();
    }

    $response["error"] = false;
    $response["course"] = array();

    // pushing single chat room into array
    while ($course = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["course_id"] = $course["course_id"];
        $tmp["course_name"] = $course["course_name"];
        $tmp["course_created_at"] = $course["created_at"];
        array_push($response["course"], $tmp);
    }

    echoRespnse(200, $response);
});

/***************************************************
 *  Get courses
 *  use this url to get courses for only one student
 ***************************************************/
$app->get('/courses/:id', function($student_id) {
    $response = array();
    $db = new DbHandler();

    // fetching all user tasks
    $result = $db->getCoursesByStudentId($student_id);
    $response["error"] = false;
    $response["course"] = array();

    // pushing single chat room into array
    while ($course = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["course_id"] = $course["course_id"];
        $lastMessage = $db->getLastMessage($course["course_id"]);
        $tmp["lastMessage"] = $lastMessage;
        $tmp["course_name"] = $course["course_name"];
        $tmp["course_created_at"] = $course["course_created_at"];
        array_push($response["course"], $tmp);
    }

    echoRespnse(200, $response);
});

/***************************************************
 *  Delete course
 *  use this url to delete course
 ***************************************************/
$app->post('/course/delete/', function() use ($app) {
    // check for required params

    verifyRequiredParams(array('course_id'));

    $response = array();

    // reading post params
    $course_id = $app->request->post('course_id');

    $db = new DbHandler();
    $res = $db->deleteCourse($course_id);
    if ($res == DELETED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "Classroom successfully delete";
        echoRespnse(201, $response);
    } else if ($res == DELETE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while deleting";
        echoRespnse(200, $response);
    } else if ($res == NOT_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this classroom not existed";
        echoRespnse(200, $response);
    }
});

/***************************************************
 *  Clean course
 *  use this url to clean course
 ***************************************************/
$app->post('/course/clean/', function() use ($app) {
    // check for required params

    verifyRequiredParams(array('course_id'));

    $response = array();

    // reading post params
    $course_id = $app->request->post('course_id');

    $db = new DbHandler();
    $res = $db->cleanCourse($course_id);
    if ($res == CLEANED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "Course successfully cleaned";
        echoRespnse(201, $response);
    } else if ($res == CLEAN_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while cleaning";
        echoRespnse(200, $response);
    } else if ($res == NOT_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this course not existed";
        echoRespnse(200, $response);
    }
});

            /*          students         */

/***************************************************
 *  Add student
 *  use this url to add new student
 ***************************************************/
$app->post('/student/add/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('student_name', 'matricula', 'password'));

    $response = array();

    // reading post params
    $student_name = $app->request->post('student_name');
    $matricula = $app->request->post('matricula');
    $password = $app->request->post('password');

    $db = new DbHandler();
    $res = $db->createStudent($student_name, $matricula, $password);
    if ($res['result'] == CREATED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["student_id"] = $res['student_id'];
        $response["message"] = "User successfully registered";
        echoRespnse(201, $response);
    } else if ($res['result'] == CREATE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        echoRespnse(200, $response);
    } else if ($res['result'] == ALREADY_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this matricula existed";
        echoRespnse(200, $response);
    }
});

/***************************************************
 *  get students
 *  use this url to get all students
 ***************************************************/
$app->get('/students/:id', function($course_id) {
    $response = array();
    $db = new DbHandler();

    // fetching all user tasks
    $result = $db->getStudents($course_id);

    $response["error"] = false;
    $response["student"] = array();

    // pushing single chat room into array
    while ($user = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["student_name"] = $user["student_name"];
        $tmp["matricula"] = $user["matricula"];
        $tmp["student_id"] = $user["student_id"];
        array_push($response["student"], $tmp);
    }

    echoRespnse(200, $response);
});

/***************************************************
 *  Login user
 *  use this url to login a user
 ***************************************************/
$app->post('/student/login/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('matricula', 'password'));

    // reading post params
    $matricula = $app->request()->post('matricula');
    $password = $app->request()->post('password');

    $db = new DbHandler();

    // check for correct user_tag and password
    if ($db->checkLogin($matricula, $password)) {
        $db -> updateDeviceKey($matricula);
        // get the user by tag
        $data = $db->getStudentByMatricula($matricula);
        $response = array();
        $response["course_id"] = array();
        $response["level_id"] = array();
        if ($data != NULL) {
            $response['error'] = false;
            $response['message'] = "Successfully login";
            $response["student_id"] = $data["student_id"] ;
            $response["student_name"] = $data["student_name"];
            $response["matricula"] = $data["matricula"];
            $response["device_key"] = $data["device_key"];
            $response["created_at"] = $data["created_at"];
            $result=$db->getCoursesByStudentId($data["student_id"]);
            while ($course = $result->fetch_assoc()) {
                //$tmp = array();
                array_push($response["course_id"], $course["course_id"]);
                array_push($response["level_id"], $course["level_id"]);
            }
        } else {
            // unknown error occurred
            $response['error'] = true;
            $response['message'] = "An error occurred. Please try again";
        }
    } else {
        // user credentials are wrong
        $response['error'] = true;
        $response['message'] = 'Login failed. Incorrect credentials';
    }

    echoRespnse(200, $response);
});

/***************************************************
 *
 *  use this url to update student's gcm registration id
 ***************************************************/
$app->post('/student/:id', function($student_id) use ($app) {
    global $app;

    verifyRequiredParams(array('gcm_registration_id'));

    $gcm_registration_id = $app->request->put('gcm_registration_id');

    $db = new DbHandler();
    $response = $db->updateGcmID($student_id, $gcm_registration_id);

    //echo json_encode($headerValueArray);
    echoRespnse(200, $response);

});


/***************************************************
 *  Authenticate students
 *  use this url to check the student's device_id
 ***************************************************/
$app->post('/student/authenticate/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('device_key'));

    // reading post params
    $device_key = $app->request()->post('device_key');

    $db = new DbHandler();

    // check for correct user_tag and password
    if ($db->isValidApiKey($device_key)) {
        $response['error'] = false;
        $response['message'] = "Successfully login";
    } else {
        // unknown error occurred
        $response['error'] = true;
        $response['message'] = "An error occurred. Please try again";
    }
    echoRespnse(200, $response);
});


/***************************************************
 *  search students
 *  use this url to search students
 ***************************************************/
$app->post('/student/search/', function() use($app) {
    // check for required params
    verifyRequiredParams(array('student_name'));

    // reading post params
    $student_name = $app->request()->post('student_name');

    $response = array();
    $db = new DbHandler();

    // fetching all user tasks
    $result = $db->searchStudents('%'.$student_name.'%');

    $response["error"] = false;
    $response["student"] = array();

    // pushing single chat room into array
    $flag=0;
    while ($user = $result->fetch_assoc()) {
        if($flag!=0){
            $tmp = $response["student"][$flag-1];
            if($tmp["student_name"]==$user["student_name"]){
                array_push($response["student"][$flag-1]["level"],$user["level_name"]);
                array_push($response["student"][$flag-1]["course"],$user["course_name"]);
            }else{
                $tmp["level"] = array();
                $tmp["course"] = array();
                $tmp["student_name"] = $user["student_name"];
                $tmp["matricula"] = $user["matricula"];
                $tmp["created_at"] = $user["created_at"];
                $course = $user["course_name"];
                $levels = $user["level_name"];
                array_push($tmp["level"],$levels);
                array_push($tmp["course"],$course);
                array_push($response["student"], $tmp);
                $flag++;
            }
        }else{
            $tmp["level"] = array();
            $tmp["course"] = array();
            $tmp["student_name"] = $user["student_name"];
            $tmp["matricula"] = $user["matricula"];
            $tmp["created_at"] = $user["created_at"];
            $course = $user["course_name"];
            $levels = $user["level_name"];
            array_push($tmp["level"],$levels);
            array_push($tmp["course"],$course);
            array_push($response["student"], $tmp);
            $flag++;
        }
    }

    echoRespnse(200, $response);
});


/***************************************************
 *  Delete student
 *  use this url to delete students
 ***************************************************/
$app->post('/student/delete/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('matricula'));

    $response = array();

    // reading post params
    $matricula = $app->request->post('matricula');

    $db = new DbHandler();
    $res = $db->delete("student_id", "students", "matricula", $matricula);
    if ($res == DELETED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "User successfully delete";
        echoRespnse(201, $response);
    } else if ($res == DELETE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while deleting";
        echoRespnse(200, $response);
    } else if ($res == NOT_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this user not existed";
        echoRespnse(200, $response);
    }
});

            /*          student_course      */

/***************************************************
 *  Assign Course to student
 *  use this url to assign a course
 ***************************************************/
$app->post('/student_course/', function() use ($app) {
    // check for required params

    verifyRequiredParams(array('course_id', 'student_id'));

    $response = array();

    // reading post params
    $course_id = $app->request->post('course_id');
    $student_id = $app->request->post('student_id');

    $db = new DbHandler();
    $res = $db->assignCourse($student_id, $course_id);
    if ($res == CREATED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "Course successfully assigned";
        echoRespnse(201, $response);
    } else if ($res == CREATE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while assigning";
        echoRespnse(200, $response);
    } else if ($res == ALREADY_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this course existe";
        echoRespnse(200, $response);
    }
});

            /*          messages         */

/***************************************************
 *  Send Message to a Classroom
 *  use this url to send message and push notification
 ***************************************************/
$app->post('/course/:id/message/', function($course_id) {
    global $app;
    $db = new DbHandler();
    verifyRequiredParams(array('admin_id', 'message', 'image'));

    $admin_id = $app->request->post('admin_id');
    $message = $app->request->post('message');
    $image = $app->request->post('image');

    $response = $db->addMessage($admin_id, $course_id, $message, $image);

    if ($response['error'] == false) {

        require_once __DIR__ . '/../libs/gcm/gcm.php';
        require_once __DIR__ . '/../libs/gcm/push.php';
        $gcm = new GCM();
        $push = new Push();

        // get the user using userid
        $admin = $db->getAdmin($admin_id);

        $data = array();
        $data['admin'] = $admin;
        $data['message'] = $response['message'];
        $data['course_id'] = $course_id;

        $push->setTitle("CIEX school");
        $push->setIsBackground(FALSE);
        $push->setFlag(PUSH_FLAG_CHATROOM);
        $push->setData($data);

        // sending push message to a topic
        $gcm->sendToTopic('topic_' . $course_id, $push->getPush());

        $response['admin'] = $admin;
        $response['error'] = false;

    }

    echoRespnse(200, $response);
});

/***************************************************
 *  Fetching single course
 *  use this url to fetch single course including all the messages
 ***************************************************/
$app->get('/course/messages/:id/', function($course_id) {
    $db = new DbHandler();

    $result = $db->getCourse($course_id);

    $response["error"] = false;
    $response["messages"] = array();
    $response['course'] = array();

    $i = 0;
    // looping through result and preparing tasks array
    while ($course = $result->fetch_assoc()) {
        // adding chat room node
        if ($i == 0) {
            $tmp = array();
            $tmp["course_id"] = $course["course_id"];
            $tmp["course_name"] = $course["course_name"];
            $tmp["created_at"] = $course["course_created_at"];
            $response['course'] = $tmp;
            $i=1;
        }

        if ($course['admin_id'] != NULL) {
            // message node
            $cmt = array();
            $cmt["message"] = $course["message"];
            $cmt["message_id"] = $course["message_id"];
            $cmt["image"] = $course["image"];
            $cmt["created_at"] = $course["created_at"];

            // user node
            $admin = array();
            $admin['id'] = $course['admin_id'];
            $admin['admin_name'] = $course['username'];
            $cmt['admin'] = $admin;

            array_push($response["messages"], $cmt);
        }
    }

    echoRespnse(200, $response);
});

            /*          books         */

/***************************************************
 *  Fetching single course
 *  use this url to fetch single course including all the messages
 ***************************************************/
$app->get('/books/:level_id/', function($level_id) {
    $response = array();
    $db = new DbHandler();

    $result = $db->getBooks($level_id);
    if($result){
        $response["error"]=false;
        $response["books"] = array();
        // pushing single chat room into array
        while ($user = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["title"] = $user["book_name"];
            $tmp["image"] = $user["book_image"];
            array_push($response["books"], $tmp);
        }
    }else{
        $response["error"] = true;
        $response["message"]="there is not books";
    }

    echoRespnse(200, $response);
});























/***************************************************
 *  Get Messages Classroom
 *  use this url to get messages from a classroom
 ***************************************************/
$app->get('/classrooms', function() {
    $response = array();
    $db = new DbHandler();

    // fetching all user tasks
    $result = $db->getAllClassrooms();

    $response["error"] = false;
    $response["chat_rooms"] = array();

    // pushing single chat room into array
    while ($classroom = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["classroom_id"] = $classroom["classroom_id"];
        $tmp["name"] = $classroom["name"];
        $tmp["created_at"] = $classroom["created_at"];
        array_push($response["chat_rooms"], $tmp);
    }

    echoRespnse(200, $response);
});


/***************************************************
 *  Resgister admin
 *  use this url to register new admin
 ***************************************************/
$app->post('/admin/register', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('admin_name', 'password','passpass'));

    $response = array();

    // reading post params
    $user_name = $app->request->post('admin_name');
    $password = $app->request->post('password');
    $passpass = $app->request->post('passpass');

    $db = new DbHandler();
    if($passpass=="/-c_i-e_x-2_0-1_6-/") {
        $res = $db->createAdmin($user_name, $password);
        if ($res == ADMIN_CREATED_SUCCESSFULLY) {
            $response["error"] = false;
            $response["message"] = "Admin successfully registered";
            echoRespnse(201, $response);
        } else if ($res == ADMIN_CREATE_FAILED) {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred while registereing";
            echoRespnse(200, $response);
        } else if ($res == ADMIN_ALREADY_EXISTED){
            $response["error"] = true;
            $response["message"] = "Admin successfully registered";
            echoRespnse(200, $response);
        }
    }else{
        $response["error"] = false;
        $response["message"] = "Admin successfully registered";
        echoRespnse(200, $response);
    }
});


/***************************************************
 *  Classes Resgister
 *  use this url to register a class to a user
 ***************************************************/
$app->post('/classes/register', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('matricula','classroom_id'));

    $response = array();

    // reading post params
    $matricula = $app->request->post('matricula');
    $classroom_id = $app->request->post('classroom_id');

    $db = new DbHandler();
    $user_id = $db->getUserIdByMatricula($matricula);
    $res = $db->createClasses($user_id, $classroom_id);
       if ($res == CLASSES_CREATED_SUCCESSFULLY) {
          $response["error"] = false;
          $response["message"] = "User successfully added to a class";
          echoRespnse(201, $response);
       } else if ($res == CLASSES_CREATE_FAILED) {
          $response["error"] = true;
          $response["message"] = "Oops! An error occurred while adding the user to a class";
          echoRespnse(200, $response);
        }else if ($res == USER_EXIST_IN_CLASSROOM){
          $response["error"] = true;
          $response["message"] = "Usuario actualmente registrado en este curso";
          echoRespnse(200, $response);
        }
});

/***************************************************
 *  Delete Classes
 *  use this url to delete classes
 ***************************************************/
$app->post('/classes/delete/', function() use ($app) {
    // check for required params

    verifyRequiredParams(array('matricula'));

    $response = array();

    // reading post params
    $matricula = $app->request->post('matricula');

    $db = new DbHandler();
    $user_id = $db->getUserByMatricula($matricula);
    $res = $db->deleteClasses($user_id);
    if ($res == USER_DELETED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "User successfully delete";
        echoRespnse(201, $response);
    } else if ($res == USER_DELETE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while deleting";
        echoRespnse(200, $response);
    } else if ($res == USER_NOT_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this user not existed";
        echoRespnse(200, $response);
    }
});















/***************************************************
 *
 *  use this url to check device key
 ***************************************************/
$app->post('/user/device_key', 'authenticateLogin', function() use ($app) {

});

/***************************************************
 *
 *  use this url to check notifications
 ***************************************************/
$app->get('/notifications','authenticate', function() {
    $response = array();
    $db = new DbHandler();

    // fetching all notifications
    $result = $db->getAllNotifications();

    $response["error"] = false;
    $response["msj"] = array();

    // pushing single notification into array
    while ($notifications = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["id"] = $notifications["id"];
        $tmp["title"] = $notifications["title"];
        $tmp["text"] = $notifications["text"];
        array_push($response["msj"], $tmp);
    }

    echoRespnse(200, $response);
});

/***************************************************
 *  user update
 *  use this url to update a user
 ***************************************************/
$app->put('/user/name/:user_tag', function($user_tag) use ($app) {
    global $app;

    verifyRequiredParams(array('name'));

    $name = $app->request->put('name');

    print_r($name);
    $db = new DbHandler();
    $response = $db->updateUserName($user_tag, $name);

    echoRespnse(200, $response);
});

/**
 * Sending push notification to a single user
 * We use user's gcm registration id to send the message
 * * */
$app->post('/users/:id/message', function($to_user_id) {
    global $app;
    $db = new DbHandler();

    verifyRequiredParams(array('message'));

    $from_user_id = $app->request->post('user_id');
    print_r($from_user_id);
    $message = $app->request->post('message');

    $response = $db->addMessage($user_id, $chat_room_id, $message);

    if ($response['error'] == false) {
        require_once __DIR__ . '/../libs/gcm/gcm.php';
        require_once __DIR__ . '/../libs/gcm/push.php';
        $gcm = new GCM();
        $push = new Push();

        $user = $db->getUser($to_user_id);

        $data = array();
        $data['user'] = $user;
        $data['message'] = $response['message'];
        $data['image'] = '';

        $push->setTitle("Google Cloud Messaging");
        $push->setIsBackground(FALSE);
        $push->setFlag(PUSH_FLAG_USER);
        $push->setData($data);

        // sending push message to single user
        $gcm->send($user['gcm_registration_id'], $push->getPush());

        $response['user'] = $user;
        $response['error'] = false;
    }

    echoRespnse(200, $response);
});


/**
 * Sending push notification to multiple users
 * We use gcm registration ids to send notification message
 * At max you can send message to 1000 recipients
 * * */
$app->post('/users/message', function() use ($app) {

    $response = array();
    verifyRequiredParams(array('user_id', 'to', 'message'));

    require_once __DIR__ . '/../libs/gcm/gcm.php';
    require_once __DIR__ . '/../libs/gcm/push.php';

    $db = new DbHandler();

    $user_id = $app->request->post('user_id');
    $to_user_ids = array_filter(explode(',', $app->request->post('to')));
    $message = $app->request->post('message');

    $user = $db->getUser($user_id);
    $users = $db->getUsers($to_user_ids);

    $registration_ids = array();

    // preparing gcm registration ids array
    foreach ($users as $u) {
        array_push($registration_ids, $u['gcm_registration_id']);
    }

    // insert messages in db
    // send push to multiple users
    $gcm = new GCM();
    $push = new Push();

    // creating tmp message, skipping database insertion
    $msg = array();
    $msg['message'] = $message;
    $msg['message_id'] = '';
    $msg['chat_room_id'] = '';
    $msg['created_at'] = date('Y-m-d G:i:s');

    $data = array();
    $data['user'] = $user;
    $data['message'] = $msg;
    $data['image'] = '';

    $push->setTitle("Google Cloud Messaging");
    $push->setIsBackground(FALSE);
    $push->setFlag(PUSH_FLAG_USER);
    $push->setData($data);

    // sending push message to multiple users
    $gcm->sendMultiple($registration_ids, $push->getPush());

    $response['error'] = false;

    echoRespnse(200, $response);
});

$app->post('/users/send_to_all', function() use ($app) {

    $response = array();
    verifyRequiredParams(array('user_id', 'message'));

    require_once __DIR__ . '/../libs/gcm/gcm.php';
    require_once __DIR__ . '/../libs/gcm/push.php';

    $db = new DbHandler();

    $user_id = $app->request->post('user_id');
    $message = $app->request->post('message');

    require_once __DIR__ . '/../libs/gcm/gcm.php';
    require_once __DIR__ . '/../libs/gcm/push.php';
    $gcm = new GCM();
    $push = new Push();

    // get the user using userid
    $user = $db->getUser($user_id);

    // creating tmp message, skipping database insertion
    $msg = array();
    $msg['message'] = $message;
    $msg['message_id'] = '';
    $msg['chat_room_id'] = '';
    $msg['created_at'] = date('Y-m-d G:i:s');

    $data = array();
    $data['user'] = $user;
    $data['message'] = $msg;
    $data['image'] = 'http://www.androidhive.info/wp-content/uploads/2016/01/Air-1.png';

    $push->setTitle("Google Cloud Messaging");
    $push->setIsBackground(FALSE);
    $push->setFlag(PUSH_FLAG_USER);
    $push->setData($data);

    // sending message to topic `global`
    // On the device every user should subscribe to `global` topic
    $gcm->sendToTopic('global', $push->getPush());

    $response['user'] = $user;
    $response['error'] = false;

    echoRespnse(200, $response);
});

$app->post('/key', 'authenticate', function() use ($app) {
    global $user;
    $response["error"] = false;
    $response["message"] = "usuario logeado";
    $response["name"] = $user;
    echoRespnse(200, $response);
});


/***************************************************
 *  verify Required Params
 *  use this url to verify the params
 ***************************************************/
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();

    $request_params = $_REQUEST;

    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        print_r($app);
        parse_str($app->request()->getBody(), $request_params);

    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(200, $response);
        $app->stop();
    }
}

/***************************************************
 *  Validate Email
 *  use this url to validate the email
 ***************************************************/
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}

function IsNullOrEmptyString($str) {
    return (!isset($str) || trim($str) === '');
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

function authenticateLogin(\Slim\Route $route) {
    // Getting request headers
    $headers = $_SERVER;

    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['HTTP_ACCEPT'])) {
        $db = new DbHandler();

        // get the api key
        $device_key = $headers['HTTP_ACCEPT'];
        // validating api key
        if (!$db->isValidApiKey($device_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // get user primary key id
            $user_id = $db->getUserByKey($device_key);
            if ($user_id != NULL)
                $id = $user_id["user_id"];
            $response["error"] = false;
            $response["user_id"] = $id;
            echoRespnse(200, $response);
            $app->stop();
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}

function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = $_SERVER;

    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['HTTP_ACCEPT'])) {
        $db = new DbHandler();

        // get the api key
        $device_key = $headers['HTTP_ACCEPT'];
        // validating api key
        if (!$db->isValidApiKey($device_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        } else {

        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}


/****************************************************************************************************
 * CODIGO ADAN CHAVEZ OLIVERA
 *
 * agregar objetos de aprendizaje
 ****************************************************************************************************/
$app->post('/learningobjects/add/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('learningobject_name', 'learningobject_image', 'book_id'));

    $response = array();

    // reading post params
    $learningobject_name = $app->request->post('learningobject_name');
    $learningobject_image = $app->request->post('learningobject_image');
/*    $learningobject_idioma = $app->request->post('learningobject_idioma');
    $learningobject_descripcion = $app->request->post('learningobject_descripcion');
    $learningobject_version = $app->request->post('learningobject_version');
    $learningobject_autor = $app->request->post('learningobject_autor');*/
    $book_id = $app->request->post('book_id');

    $db = new DbHandler();
    $res = $db->addlearningobjects($learningobject_name, $learningobject_image, $book_id);
    if ($res['result'] == CREATED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["learningobject_id"] = $res['learningobject_id'];
        $response["message"] = "El Objeto de aprendizaje ha sido agregado";
        echoRespnse(201, $response);
    } else if ($res['result'] == CREATE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! un error ocurrio en el registro ";

        echoRespnse(200, $response);
    } else if ($res['result'] == ALREADY_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this OA existed";
        echoRespnse(200, $response);
    }

    /*$xml = new parseXML();
    $res2 = $xml->addMetadata($learningobject_name,$learningobject_idioma,
        $learningobject_descripcion, $learningobject_version, $learningobject_autor );
    if ($res2['result'] == "SUCCESSFULLY") {
        $response["error"] = false;
        $response["message"] = "User successfully registered";
        echoRespnse(201, $response);
    } else if ($res2['result'] == "FAILED") {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        echoRespnse(200, $response);
    }*/
});

/***************************************************
 *  get learningObjects
 ***************************************************/
$app->get('/learningObjects/', function() {
    $response = array();
    $db = new DbHandler();

    // fetching all user tasks
    $result = $db->getAllLearningObjects();
    $response["error"] = false;
    $response["course"] = array();

    // pushing single chat room into array
    while ($learningobject = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["learningobject_id"] = $learningobject["learningobject_id"];
        $tmp["learningobject_name"] = $learningobject["learningobject_name"];
        $tmp["book_id"] = $learningobject["book_id"];
        array_push($response["course"], $tmp);
    }

    echoRespnse(200, $response);
});


/***************************************************
 *  add exercises
 ***************************************************/
$app->post('/learningObjects/addexercises/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('learningobject', 'exercise_type', 'exercise_name','exercise_description',
        'exercise_question', 'exercise_answer1', 'exercise_answer2', 'exercise_answer3', 'exercise_ok'));

    $response = array();

    // reading post params
    $learningobject = $app->request->post('learningobject');
    $exercise_name = $app->request->post('exercise_name');
    $exercise_description = $app->request->post('exercise_description');
    $exercise_question = $app->request->post('exercise_question');
    $exercise_answer1 = $app->request->post('exercise_answer1');
    $exercise_answer2 = $app->request->post('exercise_answer2');
    $exercise_answer3 = $app->request->post('exercise_answer3');
    $exercise_type = $app->request->post('exercise_type');
    $exercise_ok = $app->request->post('exercise_ok');




    $xml = new parseXML();
    $res2 = $xml->addexercises($learningobject,$exercise_type ,$exercise_name, $exercise_description,
        $exercise_question, $exercise_answer1, $exercise_answer2, $exercise_answer3, $exercise_ok);
    if ($res2['result'] == "SUCCESSFULLY") {
        $response["error"] = false;
        $response["message"] = "El ejercicio fue agregado correctamente";
        echoRespnse(201, $response);
    } else if ($res2['result'] == "FAILED") {
        $response["error"] = true;
        $response["message"] = "Oops! Un error ocurrio en el registro";
        echoRespnse(200, $response);
    }
});


$app->post('/learningObjects/addresources/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('learningobject', 'exercise_type','exercise_description'));

    $response = array();

    // reading post params
    $learningobject = $app->request->post('learningobject');
    $exercise_description = $app->request->post('exercise_description');
    $exercise_type = $app->request->post('exercise_type');


    $xml = new parseXML();
    $res2 = $xml->addresources($learningobject,$exercise_type , $exercise_description);
    if ($res2['result'] == "SUCCESSFULLY") {
        $response["error"] = false;
        $response["message"] = "El recurso multimedia ha sido agregado correctamente";
        echoRespnse(201, $response);
    } else if ($res2['result'] == "FAILED") {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        echoRespnse(200, $response);
    }
});



/***************************************************
 *  create metadata
 ***************************************************/
$app->post('/learningobjects/createmetadata/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('learningobject_name', 'learningobject_idioma',
        'learningobject_descripcion', 'learningobject_version', 'learningobject_autor', 'book_name'));

    $response = array();

    // reading post params
    $learningobject_name = $app->request->post('learningobject_name');
    $learningobject_idioma = $app->request->post('learningobject_idioma');
    $learningobject_descripcion = $app->request->post('learningobject_descripcion');
    $learningobject_version = $app->request->post('learningobject_version');
    $learningobject_autor = $app->request->post('learningobject_autor');
    $book_name = $app->request->post('book_name');

    $xml = new parseXML();
    $res = $xml->addMetadata($learningobject_name,$learningobject_idioma,
        $learningobject_descripcion, $learningobject_version, $learningobject_autor, $book_name );

    if ($res['result'] == "SUCCESSFULLY") {
        $response["error"] = false;
        $response["message"] = "User successfully registered";
        echoRespnse(201, $response);
    } else if ($res['result'] == "FAILED") {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        echoRespnse(200, $response);
    }
});




/***************************************************
 *  Add books
 ***************************************************/
$app->post('/books/add/', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('book_name', 'book_image', 'level_id'));

    $response = array();

    // reading post params
    $book_name = $app->request->post('book_name');
    $book_image = $app->request->post('book_image');
    $level_id = $app->request->post('level_id');

    $db = new DbHandler();
    $res = $db->addbooks($book_name, $book_image, $level_id);
    if ($res['result'] == CREATED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["learningobject_id"] = $res['learningobject_id'];
        $response["message"] = "La temática ha sido agregada correctamente ";
        echoRespnse(201, $response);
    } else if ($res['result'] == CREATE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        echoRespnse(200, $response);
    } else if ($res['result'] == ALREADY_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this OA existed";
        echoRespnse(200, $response);
    }
});


/***************************************************
 *  get books
 ***************************************************/
$app->get('/books/', function() {
    $response = array();
    $db = new DbHandler();

    // fetching all user tasks
    $result = $db->getAllbooks();

    $response["error"] = false;
    $response["book"] = array();

    // pushing single chat room into array
    while ($book = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["book_id"] = $book["book_id"];
        $tmp["book_name"] = $book["book_name"];
        $tmp["book_image"] = $book["book_image"];

        array_push($response["book"], $tmp);
    }

    echoRespnse(200, $response);
});




/***************************************************
 *  get exercises
 ***************************************************/
$app->get('/exercises/:id', function($name_learningobjects) {
    $response = array() ;
    $xml = new parseXML();

    // fetching all user tasks
    $result = $xml->getAllexercises($name_learningobjects);

    $response["error"] = false;
    $response["exercise"]  = $result;


    echoRespnse(200, $response);
});




$app->run();

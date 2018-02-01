<?php
/**
 * Created by PhpStorm.
 * User: azuloro
 * Date: 15/02/16
 * Time: 09:20 PM
 */
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/db_connect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    /**************************************************
    /**
     * Checking for duplicate Admin by admin_name
     * @param String $email email to check in db
     * @return boolean
     */
    private function isAdminExists($admin_name) {
        $stmt = $this->conn->prepare("SELECT admin_id from admins WHERE admin_name = ?");
        $stmt->bind_param("s", $admin_name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**************************************************
 *  Resgister user
 ***************************************************/
    public function createStudent($student_name, $matricula, $password){
        // First check if user already existed in db
        if (!$this->exists("student_id", "students", "matricula", $matricula)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO students(student_name, matricula, password) values(?,?,?)");
            $stmt->bind_param("sss", $student_name, $matricula, $password_hash);
            $result = $stmt->execute();
            $student_id = $this->conn->insert_id;
            $stmt->close();

            // Check for successful insertion
            if ($result) {
                $response["result"] = CREATED_SUCCESSFULLY;
                $response["student_id"] = $student_id;

                // User successfully inserted
                return $response;
            } else {
                $response["result"] = CREATE_FAILED;
                // Failed to create userid
                return $response;
            }
        } else {
            // User with same email already existed in the db
            $response["result"] = ALREADY_EXISTED;
            // Failed to create userid
            return $response;
        }
    }


    /**************************************************
     *  Delete something
     ***************************************************/
    public function deleteCourse($course_id){
        // First check if user already existed in db
        if ($this->exists($course_id, "courses", "course_id", $course_id)) {

            // insert query
            $stmt = $this->conn->prepare("DELETE FROM courses WHERE course_id = ?");

            $stmt->bind_param("i", $course_id);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return DELETED_SUCCESSFULLY;
            } else {
                // Failed to create userid
                return DELETE_FAILED;
            }
        } else {
            // User with same email not existed in the db
            return NOT_EXISTED;
        }
    }

    /**************************************************
     * check if admin is teacher
     ***************************************************/
    public function isTeacher($admin_id){
        $stmt = $this->conn->prepare("SELECT is_teacher FROM admins WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;

    }
    /**************************************************
     *  Resgister admin
     ***************************************************/
    public function createAdmin($admin_name, $password, $is_teacher){
        // First check if user already existed in db
        if(!$this->isAdminExists($admin_name)){
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO admins(admin_name, password, is_teacher) values(?,?,?)");
            $stmt->bind_param("ssi", $admin_name, $password_hash, $is_teacher);
            $result = $stmt->execute();
            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return CREATED_SUCCESSFULLY;
            } else {
                // Failed to create userid
                return CREATE_FAILED;
            }
        }else{
            return ALREADY_EXISTED;
        }
    }

    /**************************************************
     *  Resgister classes
     ***************************************************/
    public function createClasses($user_id, $classroom_id){
                // insert query
        if(!$this->isUserInClasses($user_id, $classroom_id)) {
            $stmt = $this->conn->prepare("INSERT INTO classes(user_id, classroom_id) values(?,?)");
            $stmt->bind_param("is", $user_id, $classroom_id);
            $result = $stmt->execute();
            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return CLASSES_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create userid
                return CLASSES_CREATE_FAILED;
            }
        }else{
            return USER_EXIST_IN_CLASSROOM;
        }
    }

    /**************************************************
     *  Resgister course
     ***************************************************/
    public function assignCourse($student_id, $course_id){
        // insert query
        if(!$this->isStudentInCourse($student_id, $course_id)) {
            $stmt = $this->conn->prepare("INSERT INTO courses_students(student_id, course_id) values(?,?)");
            $stmt->bind_param("ii", $student_id, $course_id);
            $result = $stmt->execute();
            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return CREATED_SUCCESSFULLY;
            } else {
                // Failed to create userid
                return CREATE_FAILED;
            }
        }else{
            return ALREADY_EXISTED;
        }
    }

    /**************************************************
     *  Delete something
     ***************************************************/
    public function delete($id, $from, $where, $key){
        // First check if user already existed in db
        if ($this->exists($id, $from, $where, $key)) {

            // insert query
            $stmt = $this->conn->prepare("DELETE FROM ".$from." WHERE ".$where." = ?");

            $stmt->bind_param("s", $key);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return DELETED_SUCCESSFULLY;
            } else {
                // Failed to create userid
                return DELETE_FAILED;
            }
        } else {
            // User with same email not existed in the db
            return NOT_EXISTED;
        }
    }

    /**************************************************
     *  Delete user
     ***************************************************/
    public function deleteClasses($user_id){
        // insert query
            $stmt = $this->conn->prepare("DELETE FROM classes WHERE user_id = ?");

            $stmt->bind_param("s", $user_id);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_DELETED_SUCCESSFULLY;
            } else {
                // Failed to create userid
                return USER_DELETE_FAILED;
            }
    }

    /**************************************************
     *  Get Users
     ***************************************************/
    public function getAllStudents(){

        $stmt = $this->conn->prepare("SELECT * FROM students");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    /**************************************************
     *  Get Users
     ***************************************************/
    public function getStudents($c_id){

        $stmt = $this->conn->prepare("SELECT students.student_id, student_name, matricula FROM students INNER JOIN  courses_students ON students.student_id = courses_students.student_id WHERE courses_students.course_id=?");
        $stmt->bind_param("i", $c_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }


    /**************************************************
     *  Delete Classroom
     ***************************************************/
    public function deleteClassroom($classroom_id){
        // First check if user already existed in db
        if ($this->isClassroomExists($classroom_id)) {

            // insert query
            $stmt = $this->conn->prepare("DELETE FROM classrooms WHERE classroom_id = ?");

            $stmt->bind_param("i", $classroom_id);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return CLASS_DELETED_SUCCESSFULLY;
            } else {
                // Failed to create userid
                return CLASS_DELETE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return CLASS_NOT_EXISTED;
        }
    }

    /**************************************************
     *  Clean Classroom
     ***************************************************/
    public function cleanCourse($course_id){
        // First check if user already existed in db
        if ($this->exists("course_id","courses","course_id",$course_id)) {

            // insert query
            $stmt = $this->conn->prepare("DELETE FROM messages WHERE course_id = ?");

            $stmt->bind_param("i", $course_id);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return CLEANED_SUCCESSFULLY;
            } else {
                // Failed to create userid
                return CLEAN_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return NOT_EXISTED;
        }
    }

    /**************************************************
     *  Check login user
     ***************************************************/
    public function checkLogin($matricula, $password) {
        // fetching user by tag(matricula)
        $stmt = $this->conn->prepare("SELECT password FROM students WHERE matricula = ?");

        $stmt->bind_param("s", $matricula);

        $stmt->execute();

        $stmt->bind_result($password_hash);

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Found user with the tag
            // Now verify the password
            $stmt->fetch();

            $stmt->close();

            if (PassHash::check_password($password_hash, $password)) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            $stmt->close();

            // user not existed with the tag
            return FALSE;
        }
    }

    /**************************************************
     *  Check login admin
     ***************************************************/
    public function checkLoginAdmin($admin_name, $password) {
        // fetching user by tag(matricula)
        $stmt = $this->conn->prepare("SELECT password FROM admins WHERE admin_name = ?");

        $stmt->bind_param("s", $admin_name);

        $stmt->execute();
        $password_hash="";
        $stmt->bind_result($password_hash);

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Found user with the tag
            // Now verify the password
            $stmt->fetch();

            $stmt->close();

            if (PassHash::check_password($password_hash, $password)) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            $stmt->close();

            // user not existed with the tag
            return FALSE;
        }
    }

    // updating device_key
    public function updateDeviceKey($matricula) {
        // GeneratingPassHash device_key
        $device_key = $this->generateDeviceKey();

        $response = array();
        $stmt = $this->conn->prepare("UPDATE students SET device_key = ? WHERE matricula = ?");
        $stmt->bind_param("ss", $device_key, $matricula);

        if ($stmt->execute()) {
            // User successfully updated
            $response["error"] = false;
            $response["message"] = 'device key updated successfully';
        } else {
            // Failed to update user
            $response["error"] = true;
            $response["message"] = "Failed to update device key";
            $stmt->error;
        }
        $stmt->close();

        return $response;
    }


// updating user GCM registration ID
    public function updateGcmID($user_id, $gcm_registration_id) {
        $response = array();
        $stmt = $this->conn->prepare("UPDATE students SET gcm_registration_id = ? WHERE student_id = ?");
        $stmt->bind_param("si", $gcm_registration_id, $user_id);

        if ($stmt->execute()) {
            // User successfully updated
            $response["error"] = false;
            $response["message"] = 'GCM registration ID updated successfully';
        } else {
            // Failed to update user
            $response["error"] = true;
            $response["message"] = "Failed to update GCM registration ID";
            $stmt->error;
        }
        $stmt->close();

        return $response;
    }

    // fetching single user by id
    public function getUser($user_id) {
        $stmt = $this->conn->prepare("SELECT user_id, name, matricula, gcm_registration_id, created_at FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($user_id, $name, $matricula, $gcm_registration_id, $created_at);
            $stmt->fetch();
            $user = array();
            $user["user_id"] = $user_id;
            $user["name"] = $name;
            $user["matricula"] = $matricula;
            $user["gcm_registration_id"] = $gcm_registration_id;
            $user["created_at"] = $created_at;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    public function getAdmin($admin_id) {
        $stmt = $this->conn->prepare("SELECT admin_id, admin_name, is_teacher FROM admins WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($admin_id, $admin_name, $is_teacher);
            $stmt->fetch();
            $user = array();
            $user["admin_id"] = $admin_id;
            $user["admin_name"] = $admin_name;
            $user["is_teacher"] = $is_teacher;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    // fetching multiple users by ids
    public function getUsers($user_ids) {

        $users = array();
        if (sizeof($user_ids) > 0) {
            $query = "SELECT user_id, name, email, gcm_registration_id, created_at FROM users WHERE user_id IN (";

            foreach ($user_ids as $user_id) {
                $query .= $user_id . ',';
            }

            $query = substr($query, 0, strlen($query) - 1);
            $query .= ')';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($user = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["user_id"] = $user['user_id'];
                $tmp["name"] = $user['name'];
                $tmp["email"] = $user['email'];
                $tmp["gcm_registration_id"] = $user['gcm_registration_id'];
                $tmp["created_at"] = $user['created_at'];
                array_push($users, $tmp);
            }
        }

        return $users;
    }

    // messaging in a chat room / to persional message
    public function addMessage($admin_id, $course_id, $message, $image) {
        $response = array();
        if($image=="NO"){
            $stmt = $this->conn->prepare("INSERT INTO messages (course_id, admin_id, message) values(?, ?, ?)");
            $stmt->bind_param("sss", $course_id, $admin_id, $message);
        }else{
            $stmt = $this->conn->prepare("INSERT INTO messages (course_id, admin_id, message, image) values(?, ?, ?, ?)");
            $stmt->bind_param("ssss", $course_id, $admin_id, $message, $image);
        }

        $result = $stmt->execute();

        if ($result) {
            $response['error'] = false;

            // get the message
            $message_id = $this->conn->insert_id;
            $stmt = $this->conn->prepare("SELECT message_id, admin_id, course_id, message, image, created_at FROM messages WHERE message_id = ?");
            $stmt->bind_param("i", $message_id);
            if ($stmt->execute()) {
                $stmt->bind_result($message_id, $admin_id, $course_id, $message, $image, $created_at);
                $stmt->fetch();
                $stmt->close();
                $tmp = array();
                $tmp['message_id'] = $message_id;
                $tmp['course_id'] = $course_id;
                $tmp['message'] = $message;
                $tmp['created_at'] = $created_at;
                $tmp['image'] = $image;
                $response['message'] = $tmp;
                $response['error'] = 0;
            }
        } else {
            $stmt->close();
            $response['error'] = true;
            $response['message'] = 'Failed send message';
        }

        return $response;
    }


    // Add into somewher
    public function add($select, $from, $where, $key) {
        // First check if user already existed in db
        if (!$this->exists($select, $from, $where, $key)) {

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO ".$from." (".$where.") values(?)");
            $stmt->bind_param("s", $key);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return CREATED_SUCCESSFULLY;
            } else {
                // Failed to create userid
                return CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return ALREADY_EXISTED;
        }
    }

    public function addCourse($select, $from, $where, $key, $lev_id) {
        // First check if user already existed in db
        if (!$this->exists($select, $from, $where, $key)) {

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO ".$from." (".$where.", level_id) values(?,?)");
            $stmt->bind_param("ss", $key,$lev_id);

            $result = $stmt->execute();
            $classroom_id = $this->conn->insert_id;
            $stmt->close();

            // Check for successful insertion
            if ($result) {
                $response['result']=CREATED_SUCCESSFULLY;
                $response['course_id']=$classroom_id;
                return $response;
            } else {
                // Failed to create
                $response['result']=CREATE_FAILED;
                return $response;
            }
        } else {
            // already existed in the db
            $response['result']=ALREADY_EXISTED;
            return $response;
        }
    }



    // fetching all courses
    public function getAllCourses() {
        $stmt = $this->conn->prepare("SELECT * FROM courses");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
    // fetching all courses
    public function getSomeCourses($admin_id) {
        $stmt = $this->conn->prepare("SELECT co.course_id, co.course_name, co.created_at as course_created_at, co.level_id 
        FROM courses co LEFT JOIN courses_admins c_a ON c_a.course_id = co.course_id LEFT JOIN admins ad ON ad.admin_id = c_a.admin_id 
        WHERE ad.admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    // fetching all chat rooms
    public function getCoursesByStudentId($student_id) {
        $stmt = $this->conn->prepare("SELECT co.course_id, co.course_name, co.created_at as course_created_at, co.level_id 
        FROM courses co LEFT JOIN courses_students c_e ON c_e.course_id = co.course_id LEFT JOIN students st ON st.student_id = c_e.student_id 
        WHERE st.student_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    public function getLastMessage($course_id) {
        $stmt = $this->conn->prepare("SELECT message FROM  messages WHERE course_id= ? ORDER BY message_id DESC  LIMIT 1");
        $stmt->bind_param("i", $course_id);
        if ($stmt->execute()) {
            $stmt->bind_result($message);
            $stmt->fetch();
            $stmt->close();
            return $message;
        } else {
            return NULL;
        }
    }

    // fetching single course messages by id
    function getCourse($course_id) {
        $stmt = $this->conn->prepare("SELECT co.course_id, co.course_name, co.created_at as course_created_at, ad.admin_name as username, me.* 
        FROM courses co LEFT JOIN messages me ON me.course_id = co.course_id LEFT JOIN admins ad ON ad.admin_id = me.admin_id 
        WHERE co.course_id = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    function getBooks($level_id){
        $stmt = $this->conn->prepare("SELECT book_name, book_image FROM books WHERE level_id = ?");
        $stmt->bind_param("i", $level_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $num_rows = $tasks->num_rows;
        $stmt->close();
        if($num_rows>0)
            return $tasks;
        else
            return null;

    }

    function searchStudents($student_name){
        $stmt = $this->conn->prepare("SELECT s.`student_name`,s.`matricula`,s.`created_at`,c.`course_name`,l.`level_name` 
            FROM `students` AS s INNER JOIN `courses_students`AS cs ON s.`student_id`=cs.`student_id` 
            INNER JOIN `courses` AS c ON cs.`course_id`=c.`course_id` INNER JOIN `levels` AS l ON c.`level_id`=l.`level_id` 
            WHERE student_name LIKE ? ORDER BY student_name");
        $stmt->bind_param("s", $student_name);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }


    function searchTeachers($admin_name){
        $stmt = $this->conn->prepare("SELECT admin_id, admin_name, created_at FROM admins WHERE admin_name LIKE ? AND is_teacher = 1");
        $stmt->bind_param("s", $admin_name);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isMatriculaExists($matricula) {
        $stmt = $this->conn->prepare("SELECT student_id from students WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }


    private function exists($select, $from, $where, $key){
        $stmt = $this->conn->prepare("SELECT ".$select." from ".$from." WHERE ".$where." = ?");
        //$stmt = $this->conn->prepare("SELECT classroom_id from classrooms WHERE classroom_name = ?");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();

        return $num_rows > 0;
    }

    public function isStudentInCourse($student_id, $course_id) {
        $stmt = $this->conn->prepare("SELECT id FROM courses_students WHERE student_id = ? AND course_id = ?");
        $stmt->bind_param("ii", $student_id, $course_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }


    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isClassroomExists($classroom_id) {
        $stmt = $this->conn->prepare("SELECT name from classrooms WHERE classroom_id = ?");
        $stmt->bind_param("i", $classroom_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Fetching user by matricula
     * @param String $matricula User matricula id
     */
    public function getUserByMatricula($matricula) {
        $stmt = $this->conn->prepare("SELECT user_id, name, matricula, created_at, device_key FROM users WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($user_id, $name, $matricula, $created_at, $device_key);
            $stmt->fetch();
            $user = array();
            $user["user_id"] = $user_id;
            $user["name"] = $name;
            $user["matricula"] = $matricula;
            $user["created_at"] = $created_at;
            $user["device_key"] = $device_key;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching student by matricula
     * @param String $matricula User matricula id
     */
    public function getStudentByMatricula($matricula) {
        $stmt = $this->conn->prepare("SELECT student_id, student_name, device_key, created_at FROM students WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($student_id, $student_name, $device_key, $created_at);
            $stmt->fetch();
            $student = array();
            $student["student_id"] = $student_id;
            $student["student_name"] = $student_name;
            $student["matricula"] = $matricula;
            $student["device_key"] = $device_key;
            $student["created_at"] = $created_at;
            $stmt->close();
            return $student;
        } else {
            return NULL;
        }
    }



    public function isValidApiKey($device_key) {
        $stmt = $this->conn->prepare("SELECT student_id from students WHERE  device_key = ?");
        $stmt->bind_param("s", $device_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getUserId($user_key) {
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE user_key = ?");
        $stmt->bind_param("s", $user_key);
        if ($stmt->execute()) {
            $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    public function isUserInClasses($user_id, $classroom_id) {
        $stmt = $this->conn->prepare("SELECT classes_id FROM classes WHERE classroom_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $classroom_id, $user_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }


    public function getUserIdByMatricula($matricula) {
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        if ($stmt->execute()) {
            $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    /**************************************************
     *  Resgister user
     ***************************************************/
    private function generateDeviceKey() {
        return md5(uniqid(rand(), true));
    }

    /****************************************************************************************************
     *  CODIGO ADAN CHAVEZ OLIVERA
     *
     *Agregar objetos de aprendizaje
     ****************************************************************************************************/
    public function addlearningobjects($name, $image, $book_id) {
        // First check if user already existed in db
        // if (!$this->exists("learningobject_id", "learningobjects", "learningobjects_name", $name)) {

        // insert query   ;INSERT INTO learningobjects (learninobject_name, learninobject_image, book_id) VALUES (?, ?, ?)
        $stmt = $this->conn->prepare("INSERT INTO learningobjects(learningobject_name, learningobject_type, book_id) values(?,?,?)");
        $stmt->bind_param("ssi", $name, $image, $book_id);
        $result = $stmt->execute();
        $learningobject_id = $this->conn->insert_id;
        $stmt->close();

        // Check for successful insertion
        if ($result) {
            $response["result"] = CREATED_SUCCESSFULLY;
            $response["learningobject_id"] = $learningobject_id;

            // User successfully inserted
            return $response;
        } else {
            $response["result"] = CREATE_FAILED;
            // Failed to create userid
            return $response;
        }
        /* } else {
             // already existed in the db
             $response['result']=ALREADY_EXISTED;
             return $response;
         }*/
    }


    /**************************************************
     *  get all learningobjects
     ***************************************************/
    // fetching all learningobjects
    public function getAllLearningObjects() {

        $stmt = $this->conn->prepare("SELECT * FROM learningobjects");
        //  $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        // $num_rows = $tasks->num_rows;
        $stmt->close();
        return $tasks;
    }

    // fetching One learningobjects
    public function getOneLearningObjects($learningobject_id) {

        $stmt = $this->conn->prepare("SELECT learningobject_name, book_id FROM learningobjects WHERE learningobject_id = ?");
        $stmt->bind_param("i", $learningobject_id);
        if ($stmt->execute()) {
            $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }



    /**************************************************
     *  add books(tematicas)
     ***************************************************/
    public function addbooks($name, $image, $level_id) {
        // First check if user already existed in db
        // if (!$this->exists("learningobject_id", "learningobjects", "learningobjects_name", $name)) {
        // insert query   ;INSERT INTO learningobjects (learninobject_name, learninobject_image, book_id) VALUES (?, ?, ?)
        $stmt = $this->conn->prepare("INSERT INTO books(book_name, book_image, level_id) values(?,?,?)");
        $stmt->bind_param("ssi", $name, $image, $level_id);
        $result = $stmt->execute();
        $book_id = $this->conn->insert_id;
        $stmt->close();

        // Check for successful insertion
        if ($result) {
            $response["result"] = CREATED_SUCCESSFULLY;
            $response["learningobject_id"] = $book_id;

            // User successfully inserted
            return $response;
        } else {
            $response["result"] = CREATE_FAILED;
            // Failed to create userid
            return $response;
        }
        /* } else {
             // already existed in the db
             $response['result']=ALREADY_EXISTED;
             return $response;
         }*/
    }



    // fetching all books
    public function getAllbooks() {
        $stmt = $this->conn->prepare("SELECT * FROM books");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    // fetching One book
    public function getOnebooks($book_id) {

        $stmt = $this->conn->prepare("SELECT book_name FROM books WHERE book_id = ?");
        $stmt->bind_param("i", $book_id);
        if ($stmt->execute()) {
            $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }
    /**************************************************
     *  Delete book
     ***************************************************/
    public function deletebook($id_tematica){

        $stmt = $this->conn->prepare("DELETE FROM books WHERE book_id = ?");

        $stmt->bind_param("i", $id_tematica);

        $result = $stmt->execute();

        $stmt->close();

        // Check for successful insertion
        if ($result) {
            // User successfully inserted
            return CREATED_SUCCESSFULLY;
        } else {
            // Failed to create userid
            return CREATE_FAILED;
        }
    }

    /**************************************************
     *  Delete learningobjects
     ***************************************************/
    public function deletelearningobject($id_oa){

        $stmt = $this->conn->prepare("DELETE FROM learningobjects WHERE learningobject_id = ?");

        $stmt->bind_param("i", $id_oa);

        $result = $stmt->execute();

        $stmt->close();

        // Check for successful insertion
        if ($result) {
            // User successfully inserted
            return CREATED_SUCCESSFULLY;
        } else {
            // Failed to create userid
            return CREATE_FAILED;
        }
    }

    /**************************************************
     *  search learningobjects
     ***************************************************/
    public function searchlearningobject($id) {
        $stmt = $this->conn->prepare("SELECT learningobject_name  from learningobjects WHERE learningobject_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        // $num_rows = $tasks->num_rows;
        $stmt->close();
        return $tasks;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: azuloro
 * Date: 15/02/16
 * Time: 09:15 PM
 */

//SERVER CONFIG
   // define('DB_USERNAME', 'wwwitnov_ciex'); define('DB_PASSWORD', 'Ciex2016'); define('DB_HOST', 'localhost'); define('DB_NAME', 'wwwitnov_ciex');

//LOCALHOST CONFIG
    define('DB_USERNAME', 'root'); define('DB_PASSWORD', ''); define('DB_HOST', 'localhost'); define('DB_NAME', 'ciex_');

define("GOOGLE_API_KEY", "AIzaSyAv2W47ngdsWsTqDSUeBFaZq3CegFd6jV4");

// push notification flags
define('PUSH_FLAG_CHATROOM', 1);
define('PUSH_FLAG_USER', 2);

define('CREATED_SUCCESSFULLY', 3);
define('CREATE_FAILED', 4);
define('ALREADY_EXISTED', 5);

define('DELETED_SUCCESSFULLY', 6);
define('DELETE_FAILED', 7);
define('NOT_EXISTED', 8);

define('CLEANED_SUCCESSFULLY', 9);
define('CLEAN_FAILED', 10);

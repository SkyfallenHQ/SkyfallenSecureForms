<?php

/**
 * Class SSFUser
 * Handles user account related functions.
 */
class SSFUser
{
    /**
     * @var String $error Error message that might have been generated from one of the functions
     */
    public $error;

    /**
     * @var String $username Username of the user that this object belongs to
     */
    public $username;

    /**
     * @var String $email Email of the the user that this object belongs to
     */
    private $email;

    /**
     * @var String $role Role of the user that this object belongs to
     */
    public $role;

    /**
     * @var String $type Account type of the user that this object belongs to (DB, Oauth or etc.)
     */
    private $type;


    /**
     * @var String $hashed_password Hashed Password of the user that the current object belongs to. Not retrievable.
     */
    private $hashed_password;

    /**
     * SSFUser constructor.
     * @param String $username The user to assign the new object to.
     */
    public function __construct($username)
    {
        global $connection;


    }

    /**
     * Creates a new user in the database
     * @param String $username Username of the user that we'll create
     * @param String $email Email of the user that we'll create
     * @param String $role Role of the user that we'll create
     * @param String $password Password of the user that we'll create
     * @param String $type Type/Source of the user that we'll create
     * @return bool false on fail,true on success
     */

    public static function createNewUser($username,$email,$role,$password,$type = "DIRECT"){

        global $connection;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }


        $hashed_password = password_hash($password,PASSWORD_DEFAULT);

        $stmt = $connection->stmt_init();

        $stmt->prepare("INSERT INTO ssf_users (username,email,type,role,hashed_password) VALUES (?,?,?,?,?)");

        $stmt->bind_param("sssss",$username,$email,$type,$role,$hashed_password);

        $stmt->execute();

        if($stmt->error){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Checks if a username is available in the database
     * @param String $username Username to check
     * @return bool true if username is available, false on failure or if username is already in use.
     */
    public static function isUsernameFree($username){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT username FROM ssf_users WHERE username=?");

        $stmt->bind_param("s",$username);

        $stmt->execute();

        if($stmt->error){
            return false;
        }

        $result = $stmt->get_result();

        if($result->num_rows == 0){
            return true;
        } else {
            return false;
        }

    }


    /**
     * Checks if a username is available in the database
     * @param String $email Email to check
     * @return bool true if username is available, false on failure or if username is already in use.
     */
    public static function isEmailFree($email){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT email FROM ssf_users WHERE email=?");

        $stmt->bind_param("s",$email);

        $stmt->execute();

        if($stmt->error){
            return false;
        }

        $result = $stmt->get_result();

        if($result->num_rows == 0){
            return true;
        } else {
            return false;
        }

    }

    /**
     * Fetches the username of an user by the user's email
     * @param $email Email of the user whose username will be fetched
     * @return false|mixed false on error, String Username on success
     */
    public static function getUsernameFromEmail($email){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT username FROM ssf_users WHERE email=?");

        $stmt->bind_param("s",$email);

        $stmt->execute();

        if($stmt->error){
            return false;
        }

        $result = $stmt->get_result();

        if($result->num_rows != 0){
            $row = $result->fetch_assoc();
            return $row["username"];
        } else {
            return false;
        }
    }

}
<?php

/**
 * Class SSF_Form
 * This class adds Form related functionality, but please note that this class does not contain functions for fields.
 */
class SSF_Form
{
    /**
     * @var String $formid Stores the current FORM ID
     */
    public $formid;

    /**
     * SSF_Form constructor.
     * @param String $formid Form ID used to construct the new object
     */
    public function __construct($formid)
    {

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT formid FROM ssf_forms WHERE formid=?");

        $stmt->bind_param("s",$formid);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){

            $this->formid = $formid;

            return true;

        } else {

            $this->formid = false;

            return false;

        }

    }

    /**
     * Deletes a key from a form's meta
     * @param String $keyname Name of the meta key to delete
     */
    public function deleteKey($keyname){
        global $connection;
        $stmt = $connection->stmt_init();
        $stmt->prepare("DELETE FROM ssf_form_meta WHERE formid=? AND form_meta=?");
        $stmt->bind_param("ss",$this->formid,$keyname);
        $stmt->execute();
    }

    /**
     * Sets a value for the given key in the Form Meta Database
     * @param String $keyname Name of the key
     * @param String $keyvalue Value of the key
     */
    public function setKey($keyname,$keyvalue){
        global $connection;
        $stmt = $connection->stmt_init();
        $stmt->prepare("SELECT form_meta_value FROM ssf_form_meta WHERE formid=? AND form_meta=?");
        $stmt->bind_param("ss",$this->formid,$keyname);
        $stmt->execute();
        $res = $stmt->get_result();
        $numrows = $res->num_rows;
        $res->free();
        $stmt->close();

        if($numrows == 1){
            $delete_stmt = $connection->stmt_init();
            $delete_stmt->prepare("DELETE FROM ssf_form_meta WHERE formid=? AND form_meta=?");
            $delete_stmt->bind_param("ss",$this->formid,$keyname);
            $delete_stmt->execute();
        }

        $addval_stmt = $connection->stmt_init();
        $addval_stmt->prepare("INSERT INTO ssf_form_meta (formid,form_meta,form_meta_value) VALUES (?,?,?)");
        $addval_stmt->bind_param("sss",$this->formid,$keyname,$keyvalue);
        $addval_stmt->execute();
    }

    /**
     * Fetches a key's value from the Settings Table
     * @param String $keyname Name of the key whose value will be retrieved
     * @return String|bool Returns key's value in the table
     */
    public function getKeyValue($keyname){
        global $connection;
        $value = "";
        $stmt = $connection->stmt_init();
        $stmt->prepare("SELECT form_meta_value FROM ssf_form_meta WHERE formid=? AND form_meta=?");
        $stmt->bind_param("ss",$this->formid,$keyname);
        $stmt->execute();

        $res = $stmt->get_result();
        if($res->num_rows == 0){
            $res->free();
            $stmt->close();
            return false;
        } else {
            while($row = $res->fetch_assoc()){
                $value = $row["form_meta_value"];
            }
            $res->free();
            $stmt->close();
            return $value;
        }
    }

    /**
     * This will create a new form in the database
     * @param String $form_name The name of the form the will be created
     * @param String $form_visibility The visibility of the form that will be created
     * @return bool
     */
    public static function newForm($form_name,$form_visibility){

        global $connection;

        $available_visibility_options = array("link_only");

        if(in_array($form_visibility,$available_visibility_options)){

            $stmt = $connection->stmt_init();

            $stmt->prepare("INSERT INTO ssf_forms (formid,formname,formcreator,formcreationtime,formdomain,formtype,formvisibility) VALUES (?,?,?,?,?,?,?)");

            $time_now = time();

            $rand_formid = rand_md5_hash();

            $current_Username = USERNAME;

            $faq_code = "NYI:FAQ301-001";

            $stmt->bind_param("sssssss",$rand_formid,$form_name,$current_Username,$time_now,$faq_code,$faq_code,$form_visibility);

            $stmt->execute();

            if($stmt->error){
                return false;
            } else {
                return true;
            }

        } else {
            return false;
        }

    }

    /**
     * Checks the SQL database for all Form ID's that are created by the given user.
     * @param String $username Username to look for in the database
     * @return array containing all Form ID's that belong to the user.
     */
    public static function listUserForms($username){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT formid FROM ssf_forms WHERE formcreator=?");

        $stmt->bind_param("s",$username);

        $stmt->execute();

        $result = $stmt->get_result();

        $user_formids = array();

        if($result->num_rows){

            while($row = $result->fetch_assoc()){

                array_push($user_formids,$row["formid"]);

            }

        }

        return $user_formids;
    }

    /**
     * Gets the form name for the current form object from the SQL Database
     * @return false|mixed False on error, form name on success
     */
    public function getFormName(){

        global $connection;

        $stmt = $connection->prepare("SELECT formname FROM ssf_forms WHERE formid=?");

        $stmt->bind_param("s",$this->formid);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){

            $row = $result->fetch_assoc();

            return $row["formname"];

        } else {

            return false;

        }
    }

    /**
     * Gets the form creation date in epoch format for the current form object from the SQL Database
     * @return false|mixed False on error, form creation date in epoch format on success
     */
    public function getFormEpochDate(){

        global $connection;

        $stmt = $connection->prepare("SELECT formcreationtime FROM ssf_forms WHERE formid=?");

        $stmt->bind_param("s",$this->formid);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){

            $row = $result->fetch_assoc();

            return $row["formcreationtime"];

        } else {

            return false;

        }
    }

    /**
     * Gets the form creation date in readable format for the current form object from the SQL Database
     * @return false|mixed False on error, form creation date on success
     */
    public function getFormCreationDate(){

        global $connection;

        $stmt = $connection->prepare("SELECT formcreationtime FROM ssf_forms WHERE formid=?");

        $stmt->bind_param("s",$this->formid);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){

            $row = $result->fetch_assoc();

            return gmdate('d M Y H:i',$row["formcreationtime"]);

        } else {

            return false;

        }
    }

    /**
     * Deletes a form
     * @param String $formid Form ID that will be deleted
     * @return bool true on success, false on failure
     */
    public static function deleteForm($formid)
    {

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT formid FROM ssf_forms WHERE formid=?");

        $stmt->bind_param("s",$formid);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){

            $stmtdel = $connection->stmt_init();

            $stmtdel->prepare("DELETE FROM ssf_forms WHERE formid=?");

            $stmtdel->bind_param("s",$formid);

            $stmtdel->execute();

            return true;

        } else {

            return false;

        }

    }

    /**
     * Gets the form creator for the current form object from the SQL Database
     * @return false|mixed False on error, form creator on success
     */
    public function getFormCreator(){

        global $connection;

        $stmt = $connection->prepare("SELECT formcreator FROM ssf_forms WHERE formid=?");

        $stmt->bind_param("s",$this->formid);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){

            $row = $result->fetch_assoc();

            return $row["formcreator"];

        } else {

            return false;

        }

    }

    /**
     * Renames the form bound to the current object.
     * @param String $new_name The new name of the form
     */
    public function renameForm($new_name){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("UPDATE ssf_forms SET formname=? WHERE formid=?");

        $stmt->bind_param("ss",$new_name,$this->formid);

        $stmt->execute();

    }

}
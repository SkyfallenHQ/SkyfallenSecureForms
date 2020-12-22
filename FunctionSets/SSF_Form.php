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
        $stmt->prepare("SELECT value FROM ssf_form_meta WHERE formid=? AND form_meta=?");
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
        $addval_stmt->prepare("INSERT INTO ssf_form_meta (form_id,form_meta,form_meta_value) VALUES (?,?,?)");
        $addval_stmt->bind_param("ss",$this->formid,$keyname,$keyvalue);
        $addval_stmt->execute();
    }

    /**
     * Fetches a key's value from the Settings Table
     * @param String $keyname Name of the key whose value will be retrieved
     * @return String Returns key's value in the table
     * @return Boolean if fails to execute
     */
    public function getKeyValue($keyname){
        global $connection;
        $value = "";
        $stmt = $connection->stmt_init();
        $stmt->prepare("SELECT value FROM ssf_form_meta WHERE formid=? AND form_meta=?");
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

        if(array_key_exists($form_visibility,$available_visibility_options)){

            $stmt = $connection->stmt_init();

            $stmt->prepare("INSERT INTO ssf_forms (formid,formname,formcreator,formcreationtime,formdomain,formtype,formvisibility) VALUES (?,?,?,?,?,?,?)");

            $stmt->bind_param("sssssss",rand_md5_hash(),$form_name,USERNAME,time(),"NYI:FAQ301-001","NYI:FAQ301-002",$form_visibility);

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
}
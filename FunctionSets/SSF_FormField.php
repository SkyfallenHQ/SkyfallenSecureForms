<?php

/**
 * Class SSF_FormField
 * This class handles functions related to fields in the forms
 */
class SSF_FormField
{

    /**
     * Clears all fields for a given Form ID
     * @param String $formid Form ID to clear the fields of
     */
    public static function clearFields($formid){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("DELETE FROM ssf_fields WHERE form_id=?");

        $stmt->bind_param("s",$formid);

        $stmt->execute();

    }

    /**
     * Save a new form field to the database
     * @param String $form_id FORM ID
     * @param String $field_order THE POSITION OF THE FIELD
     * @param String $field_type TYPE OF THE FIELD
     * @param String $field_id ID OF THE FIELD
     * @param String $field_name NAME OF THE FIELD
     * @param String $field_options AVAILABLE SELECTABLE OPTIONS FOR THE FIELD
     * @param String $field_description DESCRIPTION OF THE FIELD
     * @param String $field_char_limit CHAR LIMIT OF THE FIELD
     */
    public static function addField($form_id, $field_order, $field_type, $field_id, $field_name, $field_options = "", $field_description = "noval", $field_char_limit = "255"){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("INSERT INTO ssf_fields (`form_id`, `field_order`, `field_type`, `field_id`, `field_name`, `field_description`, `field_charlimit`, `field_options`) VALUES (?,?,?,?,?,?,?,?)");

        $stmt->bind_param("ssssssss",$form_id, $field_order, $field_type, $field_id ,$field_name, $field_description, $field_char_limit, $field_options);

        $stmt->execute();

    }

    /**
     * Returns an array containing all the field IDs inside the given form
     * @param String $form_id ID of the form to get fields of
     * @return array Contains all the field IDs inside the given form
     */
    public static function listFields($form_id){

        $fields = array();

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT field_id FROM ssf_fields WHERE form_id=? ORDER BY field_order ASC");

        $stmt->bind_param("s",$form_id);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0){

            while($row = $result->fetch_assoc()){

                array_push($fields,$row["field_id"]);

            }

        }

        return $fields;

    }

    /**
     * @var String Holds the Field ID of the current field.
     */
    public $field_id;

    /**
     * @var String Holds the Field Type of the current field.
     */
    public $field_type;

    /**
     * @var String Holds the Field Name of the current field.
     */
    public $field_name;

    /**
     * @var String Holds the Field Options of the current field.
     */
    public $field_options;

    /**
     * SSF_FormField constructor.
     * @param String $field_id Field ID to base this object on
     */
    public function __construct($field_id)
    {

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT field_id,field_name,field_options,field_type FROM ssf_fields WHERE field_id=?");

        $stmt->bind_param("s",$field_id);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){

            $this->field_id = $field_id;

            $row = $result->fetch_assoc();

            $this->field_name = $row["field_name"];
            $this->field_options = $row["field_options"];
            $this->field_type = $row["field_type"];

            return true;

        } else {

            $this->field_id = false;

            return false;

        }

    }

    /**
     * Saves a response for a given field
     * @param String $form_id Form ID
     * @param String $respondent_id Respondent ID
     * @param String $field_id ID of the filed to save the response of
     * @param String $response Response to save
     */
    public static function respond($form_id,$respondent_id,$field_id,$response){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("INSERT INTO ssf_responses (ssf_form_id, ssf_respondent_id, ssf_form_field_id, ssf_field_response) VALUES (?,?,?,?)");

        $stmt->bind_param("ssss",$form_id,$respondent_id,$field_id,$response);

        $stmt->execute();

    }

    /**
     * Returns an array containing all the respondent IDs
     * @param String $form_id Form ID
     * @return array Containing all respondent IDs
     */
    public static function listRespondents($form_id){

        $respondents = array();

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT ssf_respondent_id FROM ssf_responses WHERE ssf_form_id=?");

        $stmt->bind_param("s",$form_id);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0){

            while($row = $result->fetch_assoc()){

                if(!in_array($row["ssf_respondent_id"],$respondents)){
                    array_push($respondents,$row["ssf_respondent_id"]);
                }

            }

        }

        return $respondents;

    }

    /**
     * Returns a string for a given field
     * @param String $form_id Form ID
     * @param String $field_id Field ID
     * @param String $respondent_id Respondent ID
     * @param String $privKey Private RSA Key to decrypt
     */
    public static function getResponse($form_id, $field_id, $respondent_id, $privKey){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->prepare("SELECT ssf_field_response FROM ssf_responses WHERE ssf_form_id=? and ssf_form_field_id=? and ssf_respondent_id=?");

        $stmt->bind_param("sss",$form_id, $field_id, $respondent_id);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){

            $row = $result->fetch_assoc();

            $encrypted_response = $row["ssf_field_response"];

            $privKey_res = openssl_get_privatekey($privKey);

            $encrypted_response = trim($encrypted_response);

            openssl_private_decrypt($encrypted_response, $decrypted_response,$privKey_res);

            echo openssl_error_string();

            return $decrypted_response;

        } else {

            return false;

        }

    }
}
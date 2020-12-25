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
     * @param String $field_name NAME OF THE FIELD
     * @param String $field_options AVAILABLE SELECTABLE OPTIONS FOR THE FIELD
     * @param String $field_description DESCRIPTION OF THE FIELD
     * @param String $field_char_limit CHAR LIMIT OF THE FIELD
     */
    public static function addField($form_id, $field_order, $field_type, $field_name,$field_options = "", $field_description = "noval", $field_char_limit = "255"){

        global $connection;

        $stmt = $connection->stmt_init();

        $stmt->execute("INSERT INTO ssf_fields (`form_id`, `field_order`, `field_type`, `field_id`, `field_name`, `field_description`, `field_charlimit`, `field_options`) VALUES (?,?,?,?,?,?,?,?)");

        $stmt->bind_param("ssssssss",$form_id, $field_order, $field_type, $field_name, $field_description, $field_char_limit, $field_options);

        $stmt->execute();

    }

}
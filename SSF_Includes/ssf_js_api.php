<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301101                                  */
/*      This file handles the interaction between the JS Code and the database     */
/***********************************************************************************/

// Check if we are called from the main process
defined("SSF_ABSPATH") or die("Screw It!");

/**
 * Handles JS API Requests
 * @param String $afterPrefix Passed by the routing mechanism.
 */
function handle_js_api($afterPrefix){

    $user_created_forms = SSF_Form::listUserForms(USERNAME);

    if(@!in_array($_GET["form_id"],$user_created_forms) and @!in_array($_POST["form_id"],$user_created_forms)){
        include_once SSF_ABSPATH."/SSF_Includes/404.php";
        die();
    }

    $retJSON["status"] = "OK";

    switch ($afterPrefix){

        default:
            $retJSON["status"] = "ERROR";
            break;

        case "clearAllFields":
            @SSF_FormField::clearFields($_GET["form_id"]);
            @SSF_FormField::clearAllFieldMetas($_GET["form_id"]);
            break;

        case "newField":
            @SSF_FormField::addField($_GET["form_id"],$_GET["field_position"],$_GET["field_type"],$_GET["field_id"],$_GET["field_label"],$_GET["field_options"]);
            $field = new SSF_FormField($_GET["field_id"]);
            $field->setKey("isRequired",$_GET["is_required"]);
            break;

        case "setFormName":
            $form_obj = new SSF_Form($_GET["form_id"]);
            $form_obj->renameForm($_GET["new_name"]);
            break;

        case "setEncryptionStandard":
            $form_obj = new SSF_Form($_GET["form_id"]);

            $available_options = array("RSA_ONLY","RSA_PLUS_AES","DISABLED");

            $new_std = $_GET["newStandard"];

            if(!in_array($_GET["newStandard"],$available_options)){

                $new_std = "RSA_ONLY";

            }

            $form_obj->setKey("EncryptionStandard",$new_std);
            break;

        case "setFormDisclaimer":
            $form_obj = new SSF_Form($_POST["form_id"]);

            $new_disclaimer = strip_tags($_POST["new_disclaimer"],"<p></p><a></a><strong></strong><h1></h1><h2></h2><h3></h3><h4></h4><h5></h5><h6></h6><ul></ul><li></li><style></style><tr></tr><table></table><thead></thead><tbody></tbody><td></td><ol></ol><div></div>");

            $form_obj->saveLongMeta("FormDisclaimer",$new_disclaimer);
            break;

        case "setFormDescription":
            $form_obj = new SSF_Form($_POST["form_id"]);

            $new_description = strip_tags($_POST["new_description"],"<p></p><a></a><strong></strong><h1></h1><h2></h2><h3></h3><h4></h4><h5></h5><h6></h6><ul></ul><li></li><style></style><tr></tr><table></table><thead></thead><tbody></tbody><td></td><ol></ol><div></div>");

            $form_obj->saveLongMeta("FormDescription",$new_description);
            break;

    }

    echo json_encode($retJSON);

}
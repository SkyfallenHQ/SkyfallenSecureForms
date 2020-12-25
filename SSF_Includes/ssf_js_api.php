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

    if(!in_array($_GET["form_id"],$user_created_forms)){
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
            break;

        case "newField":
            @SSF_FormField::addField($_GET["form_id"],$_GET["field_position"],$_GET["field_type"],$_GET["field_id"],$_GET["field_label"],$_GET["field_options"]);
            break;
    }

    echo json_encode($retJSON);

}
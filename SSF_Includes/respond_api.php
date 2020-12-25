<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301101                                  */
/*           This file handles the API for saving form responses                   */
/***********************************************************************************/

// Check if we are called from the main process
defined("SSF_ABSPATH") or die("Screw It!");

/**
 * Handles the response API
 */
function handle_respond_api(){

    $response["status"] = "OK";

    if(!empty($_POST)){

        echo $_POST["csrf_id"];

        if(SSF_CSRF::verifyCSRF()){

            SSF_CSRF::invalidateCurrentCSRF();

            $fieldIDs = SSF_FormField::listFields($_POST["form_id"]);

            $i = 0;

            foreach ($fieldIDs as $fieldID) {

                $var_post_param = "field_".$i;

                $var_post_val = $_POST[$var_post_param];

                SSF_FormField::respond($_POST["form_id"],$_POST["respondent_id"],$fieldID,$var_post_val);

            }

        } else {

            $response["status"] = "ERROR";
            $response["error_description"] = "Invalid CSRF.";

        }

    } else {

        $response["status"] = "ERROR";
        $response["error_description"] = "This endpoint only accepts POST Requests.";

    }

    echo json_encode($response);

}
<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*            This file exports a Form's Responses to a excel file                 */
/***********************************************************************************/

/**
 * Exports an excel file out of a form's responses
 */
function exportExcel($form_id){

    $user_created_forms = SSF_Form::listUserForms(USERNAME);

    if(@!in_array($form_id,$user_created_forms)){
        include_once SSF_ABSPATH."/SSF_Includes/404.php";
        die();
    }

    $respondents = SSF_FormField::listRespondents($form_id);
    $formFields = SSF_FormField::listFields($form_id);

    include_once SSF_ABSPATH."/DataSecurity/RSA_KEYS/".USERNAME."-key.php";
    $privKey = constant(USERNAME."-PRIVATEKEY");

    $formObj = new SSF_Form($form_id);

    $timestamp = time();
    $filename = 'SecureFormsExport_' . $timestamp . '_'.$formObj->getFormName().'.xls';

    try {
        $privateKey = \phpseclib3\Crypt\RSA::loadFormat('PKCS1', $privKey);
    } catch (Exception $e) {
        $privateKey = \phpseclib3\Crypt\RSA::loadFormat('PKCS8', $privKey);
    }

    $responses = Array();

    foreach ($respondents as $respondent){

        $enc_std = SSF_FormField::getResponse($form_id,"encryptionStandard",$respondent);

        if($enc_std == ""){
            $enc_std = "RSA_ONLY";
        }

        foreach ($formFields as $formField){

            $field = new SSF_FormField($formField);

            $encryptedResponse = SSF_FormField::getResponse($form_id,$formField,$respondent);

            $decryptedResponse = "";

            switch($enc_std){
                case "DISABLED":
                    $decryptedResponse = $encryptedResponse;
                    break;

                case "RSA_ONLY":
                    $decryptedResponse = utf8_decode($privateKey->decrypt(base64_decode($encryptedResponse)));
                    break;

                case "RSA_PLUS_AES":
                    $encrypted_AES_Key = SSF_FormField::getResponse($form_id, "AES_KEY", $respondent);
                    $encrypted_AES_IV = SSF_FormField::getResponse($form_id,"AES_IV",$respondent);

                    $decrypted_AES_Key = $privateKey->decrypt(base64_decode($encrypted_AES_Key));
                    $decrypted_AES_IV = $privateKey->decrypt(base64_decode($encrypted_AES_IV));

                    $AES_Cipher = new Aes($decrypted_AES_Key, "CBC", $decrypted_AES_IV);

                    $decryptedResponse = $AES_Cipher->decrypt(base64_decode($encryptedResponse));
                    break;
            }

            if($field->field_type == "dropdown"){

                $optionIndex = $decryptedResponse;
                $optionIndex = intval(trim($optionIndex));
                $field_Options = explode("\n",$field->field_options);
                $decryptedResponse = $field_Options[$optionIndex-1];

            }

            $decryptedResponse = rtrim($decryptedResponse);

            $respondentResponse[$field->field_name] = $decryptedResponse;

        }

        array_push($responses,$respondentResponse);

    }

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    echo "File Creator:\tSkyfallenSecureForms\nSecureForms Version:\t".THIS_VERSION."\nSkyfallenExcelLibrary:\tV1.0\n\nForm Name:\t".$formObj->getFormName()."\t\t\n\n";

    $isPrintHeader = false;

    foreach ($responses as $row) {
        if (! $isPrintHeader) {
            echo implode("\t", array_keys($row)) . "\n";
            $isPrintHeader = true;
        }
        echo implode("\t", array_values($row)) . "\n";
    }

}
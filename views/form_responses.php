<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301120                                  */
/*          This file has functions to view collected form responses               */
/***********************************************************************************/

/**
 * Renders form responses
 * @param String $form_id Passed by the router
 */
function render_form_responses($form_id){
    $form_object = new SSF_Form($form_id);

    if($form_object->formid != $form_id){
    include_once SSF_ABSPATH."/SSF_Includes/404.php";
    die();
    }

    $form_CSRF = new SSF_CSRF();

    $currentFormFields = SSF_FormField::listFields($form_id);

    $respondents = SSF_FormField::listRespondents($form_id);

    include_once SSF_ABSPATH."/DataSecurity/RSA_KEYS/".USERNAME."-key.php";

    $privKey = constant(USERNAME."-PRIVATEKEY");

    $pubKey = constant(USERNAME."-PUBLICKEY");

    ?>
    <html>
    <head>
        <title><?php echo $form_object->getFormName(); ?></title>
        <?php link_std_inputs(); ?>
        <?php link_fa_icons(); ?>
        <link href="<?php the_fileurl("static/css/form-responses.css"); ?>" rel="stylesheet" type="text/css">
        <script src="<?php the_fileurl("static/js/jquery.min.js"); ?>" ></script>
        <script src="<?php the_fileurl("static/js/jsencrypt.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/sweetalert.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/form-responses.js"); ?>"></script>
        <script>
            var current_form_id = "";
            var publicEncryptionKey = ""
            var respondentID = "<?php echo rand_md5_hash(); ?>";
            var web_url = "<?php echo the_weburl(); ?>";
            $(document).ready(function () {
                    current_form_id = '<?php echo $form_id; ?>';
                    publicEncryptionKey = $("#pec_textarea").val();
                }
            );
        </script>
    </head>

    <body>
        <div class="form-title-container">
            <h1 class="form-title-hdg"><?php echo $form_object->getFormName(); ?></h1>
        </div>
        <div class="respondent-selector">
            <button onclick="selectPrev()" class="nextprev-btn"><i class="fa fa-arrow-left"></i></button>
            <select class="std-select std-blockcenter" id="response-select">
                <?php
                foreach ($respondents as $respondent) {
                    echo "<option>".$respondent."</option>";
                }
                ?>
            </select>
            <button onclick="selectNext()" class="nextprev-btn"><i class="fa fa-arrow-right"></i></button>
        </div>
        <?php foreach ($respondents as $respondent) { ?>
        <div class="form-wrapper" id="<?php echo $respondent ?>">
            <?php
            foreach ($currentFormFields as $formFieldID) {

                $formField = new SSF_FormField($formFieldID);

                $privateKey = new \ParagonIE\EasyRSA\PrivateKey($privKey);

                switch ($formField->field_type) {

                    default:
                        die("Execution Stopped due to corrupted form field;");
                        break;

                    case "textinput":
                        ?>
                        <label id='<?php echo $formFieldID; ?>-label' for='<?php echo $formFieldID; ?>-input' class="std-label"><?php echo $formField->field_name; ?></label>
                        <input class="std-textinput formfield" type="text" id="<?php echo $formFieldID; ?>-input" disabled value="<?php echo \ParagonIE\EasyRSA\EasyRSA::decrypt(SSF_FormField::getResponse($form_id, $formFieldID, $respondent),$privateKey); ?>">
                        <?php
                        break;

                    case "textarea":
                        ?>
                        <label id='<?php echo $formFieldID; ?>-label' for='<?php echo $formFieldID; ?>-previewinput' class="std-label"><?php echo $formField->field_name; ?></label>
                        <textarea class="std-textarea formfield" id="<?php echo $formFieldID; ?>-input" disabled><?php echo \ParagonIE\EasyRSA\EasyRSA::decrypt(SSF_FormField::getResponse($form_id, $formFieldID, $respondent),$privateKey); ?></textarea>
                        <?php
                        break;

                    case "dropdown":
                        ?>
                        <label id='<?php echo $formFieldID; ?>-previewlabel' for='<?php echo $formFieldID; ?>-previewinput' class="std-label"><?php echo $formField->field_name; ?></label>
                        <select id="<?php echo $formFieldID; ?>-previewinput" class="std-select formfield" disabled>
                            <option><?php
                                $optionIndex = \ParagonIE\EasyRSA\EasyRSA::decrypt(SSF_FormField::getResponse($form_id, $formFieldID, $respondent),$privateKey);
                                $field_Obejct = new SSF_FormField($formFieldID);
                                $field_Options = explode("\n",$field_Obejct->field_options);
                                echo $field_Options[$optionIndex-1];
                                ?></option>
                        </select>
                        <?php
                        break;

                }

            }

            $form_CSRF->put();
            ?>
        </div>
        <?php } ?>
    </body>
    </html>
<?php
}

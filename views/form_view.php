<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301089                                  */
/*         This file handles forms and makes them publicly viewable                */
/***********************************************************************************/

// Check if called from the main file
defined("SSF_ABSPATH") or die("Hey!");

/**
 * Renders a form publicly
 * @param String $form_id Form ID passed from the router function
 */
function render_form($form_id){

    $form_object = new SSF_Form($form_id);

    if($form_object->formid != $form_id){
        include_once SSF_ABSPATH."/SSF_Includes/404.php";
        die();
    }

    $form_CSRF = new SSF_CSRF();

    $currentFormFields = SSF_FormField::listFields($form_id);

    ?>
    <html>
    <head>
        <title><?php echo $form_object->getFormName(); ?></title>
        <?php link_std_inputs(); ?>
        <link href="<?php the_fileurl("static/css/form.css"); ?>" rel="stylesheet" type="text/css">
        <script src="<?php the_fileurl("static/js/jquery.min.js"); ?>" ></script>
        <script src="<?php the_fileurl("static/js/jsencrypt.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/sweetalert.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/form.js"); ?>"></script>
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
    <textarea id="pec_textarea" hidden>
        <?php

        $currentFormCreator = $form_object->getFormCreator();

        include_once SSF_ABSPATH."/DataSecurity/RSA_KEYS/".$currentFormCreator."-key.php";

        echo constant($currentFormCreator."-PUBLICKEY");

        ?>
    </textarea>
        <div class="form-title-container">
            <h1 class="form-title-hdg"><?php echo $form_object->getFormName(); ?></h1>
        </div>
        <div class="form-wrapper">
            <?php
            foreach ($currentFormFields as $formFieldID) {

                $formField = new SSF_FormField($formFieldID);

                switch ($formField->field_type) {

                    default:
                        die("Execution Stopped due to corrupted form field;");
                        break;

                    case "textinput":
                        ?>
                        <label id='<?php echo $formFieldID; ?>-label' for='<?php echo $formFieldID; ?>-input' class="std-label"><?php echo $formField->field_name; ?></label>
                        <input class="std-textinput formfield" type="text" id="<?php echo $formFieldID; ?>-input">
                        <?php
                        break;

                    case "textarea":
                        ?>
                        <label id='<?php echo $formFieldID; ?>-label' for='<?php echo $formFieldID; ?>-previewinput' class="std-label"><?php echo $formField->field_name; ?></label>
                        <textarea class="std-textarea formfield" id="<?php echo $formFieldID; ?>-input"></textarea>
                        <?php
                        break;

                    case "dropdown":
                        ?>
                        <label id='<?php echo $formFieldID; ?>-previewlabel' for='<?php echo $formFieldID; ?>-previewinput' class="std-label"><?php echo $formField->field_name; ?></label>
                        <select id="<?php echo $formFieldID; ?>-previewinput" class="std-select formfield">
                            <?php

                            $selectOptionsForField = explode("\n",$formField->field_options);

                            $i = 1;

                            foreach ($selectOptionsForField as $selectOptionForField){

                                echo "<option value='".$i."'>".$selectOptionForField."</option>";

                                $i = $i+1;

                            }
                            ?>
                        </select>
                        <?php
                        break;

                }

            }

            $form_CSRF->put();
            ?>
            <div class="submitparent">
                <input type="button" class="std-inputsubmit" value="Submit" onclick="submitForm()">
            </div>
        </div>

    <div id="responded" style="display: none;">
        <h2 style="font-family: sans-serif, 'Roboto'; ">Your response was saved.</h2>
    </div>
    </body>
    </html>
    <?php
}
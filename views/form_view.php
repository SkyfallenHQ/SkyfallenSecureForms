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

    $encryption_Standard = $form_object->getKeyValue("EncryptionStandard");

    if(!$encryption_Standard){
        $form_object->setKey("EncryptionStandard","RSA_ONLY");
        $encryption_Standard = $form_object->getKeyValue("EncryptionStandard");
    }

    $hasDisclaimer = "true";
    $disclaimerClass = "hidden";

    if(trim($form_object->getLongMeta("FormDisclaimer")) == ""){

        $hasDisclaimer = "false";
        $disclaimerClass = "";

    }

    ?>
    <html>
    <head>
        <title><?php echo $form_object->getFormName(); ?></title>
        <?php link_std_inputs(); ?>
        <link href="<?php the_fileurl("static/css/form.css?version=3"); ?>" rel="stylesheet" type="text/css">
        <script src="<?php the_fileurl("static/js/jquery.min.js"); ?>" ></script>
        <script src="<?php the_fileurl("static/js/forge.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/sweetalert.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/form.js?version=3"); ?>"></script>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&display=swap" rel="stylesheet">

        <script>
            var current_form_id = "";
            var publicEncryptionKey = "";
            var haveDisclaimer = <?php echo $hasDisclaimer ?>;
            var respondentID = "<?php echo rand_md5_hash(); ?>";
            var web_url = "<?php echo the_weburl(); ?>";
            $(document).ready(function () {
                    current_form_id = '<?php echo $form_id; ?>';
                    publicEncryptionKey = $("#pec_textarea").val();
                }
            );

            const encryption_standard = "<?php echo $encryption_Standard; ?>";
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
    <textarea id="aes_key" hidden></textarea>
    <textarea id="aes_iv" hidden></textarea>
        <?php

        if(trim($form_object->getLongMeta("FormDisclaimer")) != ""){

            ?>
            <div class="form-wrapper" id="form-disclaimer" style="font-family: Oxygen;">
                <div class="form-title-container">
                    <h1 class="form-title-hdg"><?php echo $form_object->getFormName(); ?></h1>
                </div>
                <?php echo $form_object->getLongMeta("FormDisclaimer"); ?>

                <div style="margin-top: 30px;">
                   <button class="std-inputsubmit" type="button" onclick="read_Disclaimer()">Proceed</button>
                </div>
            </div>
            <?php

        }
        ?>
        <div class="form-wrapper <?php echo $disclaimerClass; ?>" id="form-wrapper">
            <div class="form-title-container">
                <h1 class="form-title-hdg"><?php echo $form_object->getFormName(); ?></h1>
                <div class="form-description"><?php echo $form_object->getLongMeta("FormDescription"); ?></div>
            </div>
            <?php
            foreach ($currentFormFields as $formFieldID) {

                $formField = new SSF_FormField($formFieldID);

                switch ($formField->field_type) {

                    default:
                        die("Execution Stopped due to corrupted form field;");
                        break;

                    case "textinput":
                        ?>
                        <label id='<?php echo $formFieldID; ?>-label' for='<?php echo $formFieldID; ?>-input' class="std-label <?php if($formField->isRequired()){ echo "required-label"; } ?>"><?php echo $formField->field_name; ?></label>
                        <input class="std-textinput formfield <?php $formField->getRequiredClassName(); ?>" type="text" id="<?php echo $formFieldID; ?>-input">
                        <?php
                        break;

                    case "textarea":
                        ?>
                        <label id='<?php echo $formFieldID; ?>-label' for='<?php echo $formFieldID; ?>-previewinput' class="std-label <?php if($formField->isRequired()){ echo "required-label"; } ?>"><?php echo $formField->field_name; ?></label>
                        <textarea class="std-textarea formfield <?php $formField->getRequiredClassName(); ?>" id="<?php echo $formFieldID; ?>-input"></textarea>
                        <?php
                        break;

                    case "dropdown":
                        ?>
                        <label id='<?php echo $formFieldID; ?>-previewlabel' for='<?php echo $formFieldID; ?>-previewinput' class="std-label <?php if($formField->isRequired()){ echo "required-label"; } ?>"><?php echo $formField->field_name; ?></label>
                        <select id="<?php echo $formFieldID; ?>-previewinput" class="std-select formfield <?php $formField->getRequiredClassName(); ?>">
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

    <div class="form-footer">
        <img class="footer-logo" src="<?php the_fileurl("static/img/SecureFormsLogo.png"); ?>">
    </div>
    </body>
    </html>
    <?php
}
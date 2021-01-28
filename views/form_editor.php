<?php

/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301080                                  */
/*          This file contains the functions the form editor page                  */
/***********************************************************************************/

// Check if called from the main file
defined("SSF_ABSPATH") or die("How's life?");

/**
 * Renders the form editor page
 * @param String $form_id AfterPrefix, Passed by the router class
 */
function render_form_editor($form_id){

    $form_object = new SSF_Form($form_id);

    if($form_object->formid != $form_id){
        // Include the 404 Page.
        include_once SSF_ABSPATH."/SSF_Includes/404.php";
        die();
    }

    $user_created_forms = SSF_Form::listUserForms(USERNAME);

    if(!in_array($form_id,$user_created_forms)){
        include_once SSF_ABSPATH."/SSF_Includes/404.php";
        die();
    }

?>
<html>
    <head>
        <title>Edit SecureForm: <?php echo $form_object->getFormName(); ?></title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&display=swap" rel="stylesheet">
        <?php link_std_inputs(); ?>
        <?php link_fa_icons(); ?>
        <link type="text/css" rel="stylesheet" href="<?php the_fileurl("static/css/form-editor.css?version=7"); ?>">
        <script defer>
            const web_url = '<?php the_weburl(); ?>';
            const current_form_id = '<?php echo $form_id; ?>';
        </script>
        <script src="<?php the_fileurl("static/js/jquery.min.js"); ?>" ></script>
        <script src="<?php the_fileurl("static/js/jquery-ui.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/sweetalert.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/form-editor.js?revision=7"); ?>"></script>
        <?php

        $currentFormFields = SSF_FormField::listFields($form_id);

        if(count($currentFormFields) != 0) {
        ?>
        <script>

            $( document ).ready(function() {

                <?php

                foreach ($currentFormFields as $formFieldID) {

                    echo "preparePreviousField('".$formFieldID."'); \n";
                    echo "fieldDoubleInitialise('".$formFieldID."'); \n";

                }

                ?>

            });

        </script>
    <?php } ?>
    </head>

    <body>
        <noscript>Skyfallen SecureForms is heavily dependent on JavaScript. Please enable it on your browser to proceed.
        <style>

            .hovering-controls{
                display: none !important;
            }

            .form-title-container{
                display: none !important;
            }

            .editor-wrapper{
                display: none !important;
            }

        </style>
        </noscript>
        <div class="bgblurred">
        <div class="settings-modal">
            <div class="modal-top">
                <div class="close-modal"><i onclick="closeSettingsModal()" class="fa fa-times"></i></div>
            </div>
            <div class="modal-tabs">
                <div class="modal-tab">
                    <button class="modal-tab-button" id="modal-tab-btn-general" onclick="switchToModalTab('general')"><i class="fa fa-clipboard"></i><span class="span-spacer"></span>General</button>
                </div>
                <div class="modal-tab">
                    <button class="modal-tab-button" id="modal-tab-btn-data-security" onclick="switchToModalTab('data-security')"><i class="fa fa-lock"></i><span class="span-spacer"></span>Data Security</button>
                </div>
            </div>
            <div class="modal-tab-content">
                <div class="modal-tab-each" id="modal-tab-general">
                    <label for="settings_form_name" class="std-label">Form Name:</label>
                    <input class="std-textinput" placeholder="Form Name" id="settings_form_name" value="<?php echo $form_object->getFormName(); ?>">
                    <label for="form-disclaimer-setting" class="std-label">Form Disclaimer:</label>
                    <textarea class="std-textarea" placeholder="Form Disclaimer, HTML Allowed" id="form-disclaimer-setting" style="max-width: 580px; max-height: 350px;"><?php echo $form_object->getLongMeta("FormDisclaimer"); ?></textarea>
                    <label for="settings_form_name" class="std-label">Form Style:</label>
                    <select class="std-select" id="style-select">
                        <?php

                        $formStyle = $form_object->getKeyValue("FormStyle");
                        ?>
                        <option value="Style1" <?php if($formStyle == "Style1"){ echo "selected"; } ?>>Style 1</option>
                        <option value="Style2" <?php if($formStyle == "Style2"){ echo "selected"; } ?>>Style 2</option>
                    </select>
                    <input class="std-inputsubmit" type="submit" value="Save" onclick="save_General_Settings()">
                </div>
                <div class="modal-tab-each" id="modal-tab-data-security">
                    <label for="settings_form_name" class="std-label">Encryption Mode:</label>
                    <select class="std-select" id="encryption-select">
                        <?php

                        $enc_Std = $form_object->getKeyValue("EncryptionStandard");
                        ?>
                        <option value="DISABLED" <?php if($enc_Std == "DISABLED"){ echo "selected"; } ?>>Not Suggested - Disabled</option>
                        <option value="RSA_ONLY" <?php if($enc_Std == "RSA_ONLY"){ echo "selected"; } ?>>Most Secure - RSA Only (Limits to 200 Character)</option>
                        <option value="RSA_PLUS_AES" <?php if($enc_Std == "RSA_PLUS_AES"){ echo "selected"; } ?>>Very Secure - RSA+AES (No character limit)</option>
                    </select>
                    <input class="std-inputsubmit" type="submit" value="Save" onclick="save_Enc_Std()">
                </div>
            </div>
        </div>
        </div>
        <div class="hovering-controls">
            <button class="hover-ctrl-btn" onclick="add_new_field()">
                <i class="fa fa-plus-circle"></i>
            </button>
            <button class="hover-ctrl-btn" style="margin-top: 5px;" onclick="return_to_dashboard()">
                <i class="fa fa-sign-out-alt"></i>
            </button>
            <button class="hover-ctrl-btn" style="margin-top: 5px;" onclick="saveForm()">
                <i class="fa fa-save"></i>
            </button>
            <button class="hover-ctrl-btn" style="margin-top: 5px;" onclick="redirect_to_form_respond()">
                <i class="fa fa-external-link-square-alt"></i>
            </button>
            <button class="hover-ctrl-btn" style="margin-top: 5px;" onclick="redirect_to_form_responses()">
                <i class="fa fa-reply-all"></i>
            </button>
            <button class="hover-ctrl-btn" style="margin-top: 5px;" onclick="showSettingsModal()">
                <i class="fa fa-clipboard"></i>
            </button>
        </div>
        <div class="form-title-container" onclick="toggleDescription(event)">
            <h1 class="form-title-hdg" id="form-title-hdg"><?php echo $form_object->getFormName(); ?></h1>
            <textarea id="form-description-setting" class="std-textarea" placeholder="Form Description, HTML Allowed" style="margin-left: 10px; margin: auto; width: 620px !important; height: 100px !important; min-height: 0px !important; margin-bottom: 20px !important; display: none;"><?php echo $form_object->getLongMeta("FormDescription"); ?></textarea>
        </div>
        <div class="editor-wrapper">

            <?php

                foreach ($currentFormFields as $formFieldID){

                    $formField = new SSF_FormField($formFieldID);

                    switch ($formField->field_type) {

                        case "textinput":

                            ?>

                            <div class="field-wrap" id="<?php echo $formFieldID; ?>" onclick="swapEditPreview(event,'<?php echo $formFieldID; ?>')">
                                <div class="field-top-wrap" id="<?php echo $formFieldID; ?>-topwrap">
                                    <select class="std-select field-type-select-alt" id='<?php echo $formFieldID; ?>-typeselect'>
                                        <option value='textinput' selected>Text Input</option>
                                        <option value='textarea'>Textarea</option>
                                        <option value='dropdown'>Dropdown</option>
                                    </select>
                                    <label class="std-checkbox-container floatright">
                                        Mark this field as required
                                        <input type="checkbox" id="<?php echo $formFieldID; ?>-isrequired" class="std-checkbox" <?php $formField->getRequiredChecked(); ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                    <button class='trash-field' onclick="deleteField('<?php echo $formFieldID; ?>')"><i class='fa fa-trash'></i></button>
                                </div>

                                <div class="field-preview-wrap" id="<?php echo $formFieldID; ?>-previewwrap">
                                    <input class="std-textinput field-label-input field-labelset" type="text" id='<?php echo $formFieldID; ?>-labelset' placeholder="Field Label" value="<?php echo $formField->field_name; ?>">
                                    <label id='<?php echo $formFieldID; ?>-previewlabel' for='<?php echo $formFieldID; ?>-previewinput' class="std-label <?php if($formField->isRequired()){ echo "required-label"; } ?>" style="display: none;"><?php echo $formField->field_name; ?></label>
                                    <input class="std-textinput" type="text" id="<?php echo $formFieldID; ?>-previewinput">
                                </div>
                                <div class="field-bottom-wrap" id="<?php echo $formFieldID; ?>-bottomwrap"></div>
                            </div>

                        <?php
                            break;

                        case "textarea":
                        ?>
                            <div class="field-wrap" id="<?php echo $formFieldID; ?>" onclick="swapEditPreview(event,'<?php echo $formFieldID; ?>')">
                                <div class="field-top-wrap" id="<?php echo $formFieldID; ?>-topwrap">
                                    <select class="std-select field-type-select-alt" id='<?php echo $formFieldID; ?>-typeselect'>
                                        <option value='textinput'>Text Input</option>
                                        <option value='textarea' selected>Textarea</option>
                                        <option value='dropdown'>Dropdown</option>
                                    </select>
                                    <label class="std-checkbox-container floatright">
                                        Mark this field as required
                                        <input type="checkbox" id="<?php echo $formFieldID; ?>-isrequired" class="std-checkbox" <?php $formField->getRequiredChecked(); ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                    <button class='trash-field' onclick="deleteField('<?php echo $formFieldID; ?>')"><i class='fa fa-trash'></i></button>
                                </div>

                                <div class="field-preview-wrap" id="<?php echo $formFieldID; ?>-previewwrap">
                                    <input class="std-textinput field-label-input field-labelset" type="text" id='<?php echo $formFieldID; ?>-labelset' placeholder="Field Label" value="<?php echo $formField->field_name; ?>">
                                    <label id='<?php echo $formFieldID; ?>-previewlabel' for='<?php echo $formFieldID; ?>-previewinput' class="std-label <?php if($formField->isRequired()){ echo "required-label"; } ?>" style="display: none;"><?php echo $formField->field_name; ?></label>
                                    <textarea class="std-textarea" type="text" id="<?php echo $formFieldID; ?>-previewinput"></textarea>
                                </div>
                                <div class="field-bottom-wrap" id="<?php echo $formFieldID; ?>-bottomwrap"></div>
                            </div>
                        <?php
                            break;

                        case "dropdown":
                        ?>
            <div class="field-wrap" id="<?php echo $formFieldID; ?>" onclick="swapEditPreview(event,'<?php echo $formFieldID; ?>')">
                <div class="field-top-wrap" id="<?php echo $formFieldID; ?>-topwrap">
                    <select class="std-select field-type-select-alt" id='<?php echo $formFieldID; ?>-typeselect'>
                        <option value='textinput'>Text Input</option>
                        <option value='textarea'>Textarea</option>
                        <option value='dropdown' selected>Dropdown</option>
                    </select>
                    <label class="std-checkbox-container floatright">
                        Mark this field as required
                        <input type="checkbox" id="<?php echo $formFieldID; ?>-isrequired" class="std-checkbox" <?php $formField->getRequiredChecked(); ?>>
                        <span class="checkmark"></span>
                    </label>
                    <button class='trash-field' onclick="deleteField('<?php echo $formFieldID; ?>')"><i class='fa fa-trash'></i></button>
                </div>

                <div class="field-preview-wrap" id="<?php echo $formFieldID; ?>-previewwrap">
                    <input class="std-textinput field-label-input field-labelset" type="text" id='<?php echo $formFieldID; ?>-labelset' placeholder="Field Label" value="<?php echo $formField->field_name; ?>">
                    <label id='<?php echo $formFieldID; ?>-previewlabel' for='<?php echo $formFieldID; ?>-previewinput' class="std-label <?php if($formField->isRequired()){ echo "required-label"; } ?>" style="display: none;"><?php echo $formField->field_name; ?></label>
                    <select class="std-select" type="text" id="<?php echo $formFieldID; ?>-previewinput">
                        <?php

                        $selectOptionsForField = explode("\n",$formField->field_options);

                        $i = 1;

                        foreach ($selectOptionsForField as $selectOptionForField){

                            echo "<option value='".$i."'>".$selectOptionForField."</option>";

                            $i = $i+1;

                        }
                        ?>
                    </select>
                </div>

                <div class="field-bottom-wrap" id="<?php echo $formFieldID; ?>-bottomwrap"><textarea class="std-textarea form-drop-objs" placeholder="Dropdown Objects, Separated by a line break" id="<?php echo $formFieldID; ?>-dropdown-objects"><?php echo $formField->field_options; ?></textarea></div>
            </div>
                        <?php
                            break;

                        default:
                            echo "CORRUPTED FIELD.";
                            break;

                    }

                }

            ?>
        </div>
    </body>
</html>
<?php
}
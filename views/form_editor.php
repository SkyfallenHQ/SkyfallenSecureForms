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
        <?php link_std_inputs(); ?>
        <?php link_fa_icons(); ?>
        <link type="text/css" rel="stylesheet" href="<?php the_fileurl("static/css/form-editor.css"); ?>">
        <script defer>
            const web_url = '<?php the_weburl(); ?>';
            const current_form_id = '<?php echo $form_id; ?>';
        </script>
        <script src="<?php the_fileurl("static/js/jquery.min.js"); ?>" ></script>
        <script src="<?php the_fileurl("static/js/jquery-ui.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/sweetalert.min.js"); ?>"></script>
        <script src="<?php the_fileurl("static/js/form-editor.js"); ?>"></script>
        <?php

        $currentFormFields = SSF_FormField::listFields($form_id);

        if(count($currentFormFields) != 0) {
        ?>
        <script>

            $( document ).ready(function() {

                <?php

                foreach ($currentFormFields as $formFieldID) {

                    echo "preparePreviousField('".$formFieldID."');";

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
        </div>
        <div class="form-title-container">
            <h1 class="form-title-hdg"><?php echo $form_object->getFormName(); ?></h1>
        </div>
        <div class="editor-wrapper">
            <?php

                foreach ($currentFormFields as $formFieldID){

                    $formField = new SSF_FormField($formFieldID);

                    switch ($formField->field_type) {

                        case "textinput":
                        ?>
                            <div class="field-container" id='<?php echo $formFieldID; ?>'>
                                <div class="field-label-selector" id='<?php echo $formFieldID; ?>-labelselector'>
                                    <label for='<?php echo $formFieldID; ?>-labelset' class="std-label field-label-domlabel">Field Label:</label>
                                    <input class="std-textinput field-label-input" type="text" id='<?php echo $formFieldID; ?>-labelset' placeholder="Field Label" value="<?php echo $formField->field_name; ?>">
                                    <select class="std-select field-type-select" id='<?php echo $formFieldID; ?>-typeselect'>
                                        <option value='textinput' selected>Text Input</option>
                                        <option value='textarea'>Textarea</option>
                                        <option value='dropdown'>Dropdown</option>
                                    </select>
                                </div>
                                <p class="preview-label-explanation">Preview: <button class='trash-field' onclick="deleteField('<?php echo $formFieldID; ?>')"><i class='fa fa-trash'></i></button></p>
                                <hr>
                                <div class="field-preview-selector">
                                    <label id='<?php echo $formFieldID; ?>-previewlabel' for='<?php echo $formFieldID; ?>-previewinput' class="std-label"><?php echo $formField->field_name; ?></label>
                                    <input class="std-textinput" type="text" id="<?php echo $formFieldID; ?>-previewinput">
                                </div>
                            </div>
                        <?php
                            break;

                        case "textarea":
                        ?>
                            <div class="field-container" id='<?php echo $formFieldID; ?>'>
                                <div class="field-label-selector" id='<?php echo $formFieldID; ?>-labelselector'>
                                    <label for='<?php echo $formFieldID; ?>-labelset' class="std-label field-label-domlabel">Field Label:</label>
                                    <input class="std-textinput field-label-input" type="text" id='<?php echo $formFieldID; ?>-labelset' placeholder="Field Label" value="<?php echo $formField->field_name; ?>">
                                    <select class="std-select field-type-select" id='<?php echo $formFieldID; ?>-typeselect'>
                                        <option value='textinput'>Text Input</option>
                                        <option value='textarea' selected>Textarea</option>
                                        <option value='dropdown'>Dropdown</option>
                                    </select>
                                </div>
                                <p class="preview-label-explanation">Preview: <button class='trash-field' onclick="deleteField('<?php echo $formFieldID; ?>')"><i class='fa fa-trash'></i></button></p>
                                <hr>
                                <div class="field-preview-selector">
                                    <label id='<?php echo $formFieldID; ?>-previewlabel' for='<?php echo $formFieldID; ?>-previewinput' class="std-label"><?php echo $formField->field_name; ?></label>
                                    <textarea class="std-textarea" id="<?php echo $formFieldID; ?>-previewinput"></textarea>
                                </div>
                            </div>
                        <?php
                            break;

                        case "dropdown":
                        ?>
                            <div class="field-container" id='<?php echo $formFieldID; ?>'>
                                <div class="field-label-selector" id='<?php echo $formFieldID; ?>-labelselector'>
                                    <label for='<?php echo $formFieldID; ?>-labelset' class="std-label field-label-domlabel">Field Label:</label>
                                    <input class="std-textinput field-label-input" type="text" id='<?php echo $formFieldID; ?>-labelset' placeholder="Field Label" value="<?php echo $formField->field_name; ?>">
                                    <select class="std-select field-type-select" id='<?php echo $formFieldID; ?>-typeselect'>
                                        <option value='textinput'>Text Input</option>
                                        <option value='textarea'>Textarea</option>
                                        <option value='dropdown' selected>Dropdown</option>
                                    </select>
                                    <label for="<?php echo $formFieldID; ?>-dropdown-objects" id="<?php echo $formFieldID; ?>-dropdown-objects-label" class="std-label" style="color: white;">Dropdown Options:</label>
                                    <textarea class="std-textarea" style="width: 550px; height: 100px; resize: none;" placeholder="Seperated by a line break" id="<?php echo $formFieldID; ?>-dropdown-objects"><?php echo $formField->field_options; ?></textarea>
                                </div>
                                <p class="preview-label-explanation">Preview: <button class='trash-field' onclick="deleteField('<?php echo $formFieldID; ?>')"><i class='fa fa-trash'></i></button></p>
                                <hr>
                                <div class="field-preview-selector">
                                    <label id='<?php echo $formFieldID; ?>-previewlabel' for='<?php echo $formFieldID; ?>-previewinput' class="std-label"><?php echo $formField->field_name; ?></label>
                                    <select id="<?php echo $formFieldID; ?>-previewinput" class="std-select">
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
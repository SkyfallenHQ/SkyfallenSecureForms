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

?>
<html>
    <head>
        <title>Edit SecureForm: <?php echo $form_object->getFormName(); ?></title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <?php link_std_inputs(); ?>
        <?php link_fa_icons(); ?>
        <link type="text/css" rel="stylesheet" href="<?php the_fileurl("static/css/form-editor.css"); ?>">
        <script src="<?php the_fileurl("static/js/jquery.min.js"); ?>" defer></script>
        <script src="<?php the_fileurl("static/js/jquery-ui.min.js"); ?>" defer></script>
        <script src="<?php the_fileurl("static/js/form-editor.js"); ?>" defer></script>
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
        </div>
        <div class="form-title-container">
            <h1 class="form-title-hdg"><?php echo $form_object->getFormName(); ?></h1>
        </div>
        <div class="editor-wrapper">
        </div>
    </body>
</html>
<?php
}
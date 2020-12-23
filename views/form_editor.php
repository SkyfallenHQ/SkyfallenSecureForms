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
        <?php link_std_inputs(); ?>
        <link type="text/css" rel="stylesheet" href="<?php the_fileurl("assets/css/form-editor.css"); ?>">
        <script src="<?php the_fileurl("assets/js/jquery.min.js"); ?>" defer></script>
        <script src="<?php the_fileurl("assets/js/form-editor.js"); ?>" defer></script>
    </head>

    <body>
        
    </body>
</html>
<?php
}
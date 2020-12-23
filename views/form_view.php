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

?>
<html>
    <head>
        <title><?php echo $form_object->getFormName(); ?></title>
        <?php link_std_inputs(); ?>
        <link href="<?php the_fileurl("static/css/form.css"); ?>" rel="stylesheet" type="text/css">
    </head>

    <body>

    </body>
</html>
<?php
}
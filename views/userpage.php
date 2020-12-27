<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301080                                  */
/*                   This file renders the user dashboard                          */
/***********************************************************************************/

// Check if called from the main file
defined("SSF_ABSPATH") or die("Not funny.");

/**
 * Renders the dashboard
 */
function render_dashboard(){

    $user_created_forms = SSF_Form::listUserForms(USERNAME);

?>
<html>
    <head>
        <title>Skyfallen SecureForms: Dashboard</title>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/dash.css"); ?>">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <?php link_fa_icons(); ?>
    </head>


    <body>
        <div class="top-bar">
            <a href="<?php the_pageurl("accounts/dashboard"); ?>">
                <div class="skyfallen-logo">
                    <img src="<?php the_fileurl("static/img/Skyfallen_Logo.png"); ?>" class="skyfallen-logo-img">
                </div>
            </a>
            <div class="user-col-parent">
                <div class="user-col">
                    <a><h3>Client Side RSA is enabled and working properly.</h3></a>
                </div>
                <div class="user-col">
                    <a><h3>AES is not supported.</h3></a>
                </div>
                <div class="user-col">
                    <a href="<?php the_pageurl("updates"); ?>"><h3>Software Update</h3></a>
                </div>
                <div class="user-col">
                    <a href="<?php the_pageurl("accounts/logout"); ?>"><h3>Logged in as <?php echo USERNAME; ?>. Log out?</h3></a>
                </div>
            </div>
        </div>
        <div class="forms-overview">
            <?php
            render_form_tile_add();

            foreach ($user_created_forms as $user_created_form) {

                render_created_form_tile($user_created_form);

            }

            ?>
        </div>
    </body>
</html>
<?php
}

/**
 * Renders a tile that shows a plus icon
 */
function render_form_tile_add(){
?>
    <a href="<?php the_pageurl("accounts/dashboard/newform"); ?>">
        <div class="tile-parent">
            <div class="tile-content-plus">
                <p class="tile-plus-txt">+</p>
            </div>
        </div>
    </a>
<?php
}

/**
 * Renders a tile for a given form id
 */
function render_created_form_tile($formid){

    $form_obj = new SSF_Form($formid);

?>
    <div class="tile-parent">
        <a class="trash-form" href="<?php the_pageurl("forms/delete/".$formid); ?>"><i class="fa fa-trash trash-form-icon"></i></a>
        <a href="<?php the_pageurl("forms/edit/".$formid); ?>">
            <div class="tile-form-name">
                <p class="tile-form-name-text"><?php echo $form_obj->getFormName(); ?></p>
            </div>
            <div class="tile-form-creation-date">
                <p class="tile-form-creation-date-text">Created: <?php echo $form_obj->getFormCreationDate(); ?></p>
            </div>
        </a>
    </div>
<?php
}

/**
 * Renders the page to create a new form
 */
function render_page_new_form(){
    $new_form_csrf = new SSF_CSRF();
    $errorMessage = "OK";

    if(!empty($_POST)){
        if(SSF_CSRF::verifyCSRF()){
            SSF_CSRF::invalidateCurrentCSRF();
            SSF_Form::newForm($_POST["new_form_name"],$_POST["form_visibility"]);
            ssf_redirect("accounts/dashboard");
        } else {
            $errorMessage = "Invalid form CSRF; Please check if cookies are enabled in your browser.";
        }
    }
    ?>
    <html>
    <head>
        <title>Skyfallen SecureForms: Dashboard</title>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/dash.css"); ?>">
        <?php link_std_inputs(); ?>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    </head>


    <body>
    <div class="top-bar">
        <a href="<?php the_pageurl("accounts/dashboard"); ?>">
            <div class="skyfallen-logo">
                <img src="<?php the_fileurl("static/img/Skyfallen_Logo.png"); ?>" class="skyfallen-logo-img">
            </div>
        </a>
        <div class="user-col-parent">
            <div class="user-col">
                <a href="<?php the_pageurl("accounts/logout"); ?>"><h3>Logged in as <?php echo USERNAME; ?>. Log out?</h3></a>
            </div>
        </div>
    </div>
    <div class="create-new-form-container">
        <?php
        if($errorMessage != "OK"){
            ?>
            <div class="error-msg">
                <p><?php echo $errorMessage; ?></p>
            </div>
            <?php
        }
        ?>
        <form id="create-new-form-fields-data" method="post">
            <?php $new_form_csrf->put(); ?>
            <label class="std-label" for="new-form-name-input">Name of the form:</label>
            <input type="text" class="std-textinput" name="new_form_name" id="new-form-name-input">

            <select class="std-select" name="form_visibility">
                <option value="link_only" selected>Link Only</option>
            </select>

            <input type="submit" class="std-inputsubmit" id="submit-new-form" name="new_form_submit">
        </form>
    </div>
    <div class="forms-overview">

    </div>
    </body>
    </html>
    <?php
}


/**
 * Renders the page to delete a form
 * @param String $afterPrefix Passed by the routing system
 */
function render_page_delete_form($afterPrefix){

    $user_created_forms = SSF_Form::listUserForms(USERNAME);

    if(!in_array($afterPrefix,$user_created_forms)){
        include_once SSF_ABSPATH."/SSF_Includes/404.php";
        die();
    }

    $new_form_csrf = new SSF_CSRF();
    $errorMessage = "OK";

    if(!empty($_POST)){
        if(isset($_POST["confirmYes"])) {
            if (SSF_CSRF::verifyCSRF()) {
                SSF_CSRF::invalidateCurrentCSRF();
                SSF_FormField::clearFields($afterPrefix);
                SSF_Form::deleteForm($afterPrefix);
            } else {
                $errorMessage = "Invalid form CSRF; Please check if cookies are enabled in your browser.";
            }
        }

        ssf_redirect("accounts/dashboard");

    }
    ?>
    <html>
    <head>
        <title>Skyfallen SecureForms: Dashboard</title>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/dash.css"); ?>">
        <?php link_std_inputs(); ?>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    </head>


    <body>
    <div class="top-bar">
        <a href="<?php the_pageurl("accounts/dashboard"); ?>">
            <div class="skyfallen-logo">
                <img src="<?php the_fileurl("static/img/Skyfallen_Logo.png"); ?>" class="skyfallen-logo-img">
            </div>
        </a>
        <div class="user-col-parent">
            <div class="user-col">
                <a href="<?php the_pageurl("accounts/logout"); ?>"><h3>Logged in as <?php echo USERNAME; ?>. Log out?</h3></a>
            </div>
        </div>
    </div>
    <div class="create-new-form-container">
        <?php
        if($errorMessage != "OK"){
            ?>
            <div class="error-msg">
                <p><?php echo $errorMessage; ?></p>
            </div>
            <?php
        }
        ?>
        <form id="create-new-form-fields-data" method="post">
            <?php $new_form_csrf->put(); ?>
            <h3 class="std-label">Are you sure that you'd like to delete this form?</h3>

            <input type="submit" class="std-inputsubmit" id="submit-new-form" value="No" name="confirmNo" style="margin-top: 10px;">
            <input type="submit" class="std-inputsubmit" id="submit-new-form" value="Yes" name="confirmYes" style="margin-top: 10px;">
        </form>
    </div>
    <div class="forms-overview">

    </div>
    </body>
    </html>
    <?php
}

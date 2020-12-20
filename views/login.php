<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301009                                  */
/*           This file contains the function to render login page                  */
/***********************************************************************************/

// Check if called from the main file
defined("SSF_ABSPATH") or die();

/**
 * Redirects user to the login page
 */
function redirect_to_login(){
    ssf_redirect("accounts/login");
}

/**
 * Renders the login page.
 */

function render_login(){

    $CSRF = new SSF_CSRF();

    ?>
    <html>
        <head>
            <title>Skyfallen SecureForms: Login</title>
            <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/login.css"); ?>">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        </head>

        <body>
            <div class="left-col" style="background: url('<?php the_fileurl("static/img/color_splash.jpg"); ?>') center"></div>
            <div class="right-col">
                <div class="loginform">
                    <div class="skyfallen-logo">
                        <img src="<?php the_fileurl("static/img/Skyfallen_Logo.png"); ?>" class="skyfallen-logo-img">
                    </div>
                    <form id="mainform" method="post">
                        <?php
                            $CSRF->put();
                        ?>
                        <input class="std-input" name="username" placeholder="Username" type="text">
                        <input class="std-input" name="password" placeholder="Password" type="password">
                        <br>
                        <input class="std-submit" name="submit-form" type="submit" value="Login">
                    </form>
                </div>
            </div>
        </body>
    </html>
    <?php
}
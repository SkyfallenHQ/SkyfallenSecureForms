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
    header("location:".WEB_URL."");
}

/**
 * Renders the login page.
 */

function render_login(){

}
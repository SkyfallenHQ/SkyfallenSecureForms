<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301009                                  */
/*         This file is handles all url requests and redirects them.               */
/***********************************************************************************/

// Check if our ABSPATH is defined
defined("SSF_ABSPATH") or die("Don't mess!");

// Start routing all urls

// Redirects for the login page
include_once SSF_ABSPATH."/views/login.php";
SSF_Router::routePage("/","redirect_to_login");
SSF_Router::routePage("accounts/login","render_login");
SSF_Router::routePage("accounts/logout","do_logout");

// Redirects for the user's panel
include_once SSF_ABSPATH."/views/userpage.php";
SSF_Router::routePage("accounts/dashboard","render_dashboard",true,"redirect_to_login");
SSF_Router::routePage("accounts/dashboard/newform","render_page_new_form",true,"redirect_to_login");
SSF_Router::routePrefix("forms/delete","render_page_delete_form",true,true,"redirect_to_login");

// Redirects for the form editor
include_once SSF_ABSPATH."/views/form_editor.php";
SSF_Router::routePrefix("forms/edit","render_form_editor",true,true,"redirect_to_login");

// Redirects for the form editor
include_once SSF_ABSPATH."/views/form_responses.php";
SSF_Router::routePrefix("forms/responses","render_form_responses",true,true,"redirect_to_login");

// Redirects for the form renderer
include_once SSF_ABSPATH."/views/form_view.php";
SSF_Router::routePrefix("form","render_form",true);

// Redirects for the JS API
include_once SSF_ABSPATH."/SSF_Includes/ssf_js_api.php";
SSF_Router::routePrefix("jsapi","handle_js_api",true,true,"redirect_to_login");

// Redirects for the Respond API
include_once SSF_ABSPATH."/SSF_Includes/respond_api.php";
SSF_Router::routePage("respond","handle_respond_api");

// If nothing was routed, display 404
if(!defined("ROUTED")){

    // Include the 404 Page.
    include_once SSF_ABSPATH."/SSF_Includes/404.php";

}

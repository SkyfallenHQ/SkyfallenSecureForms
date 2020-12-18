<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301009                                  */
/*      This file is where all URL Requests are translated to in-app paths.        */
/***********************************************************************************/

// Prevent direct execution
defined("SSF_ABSPATH") or die("Don't mess!");

// Check if Web Server has set the path parameter
if(isset($_GET["path"])) {
    // Get full request url
    define("REQUEST", $_GET["path"]);
} else {
    // We are on the '/' directory
    define("REQUEST","/");
}

// Get our installed web url
define("WEB_URL",DBSettings::getKeyValue("WEB_URL"));

// Try to extract our sub-folder
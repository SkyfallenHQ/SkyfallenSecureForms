<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301009                                  */
/* This file is where all requests are redirected to. All file inclusions are here.*/
/***********************************************************************************/

error_reporting(E_ALL);
ini_set("display_errors",1);
ini_set("display_startup_errors",1);


// Define the application's ABSOLUTE FS Path
define("SSF_ABSPATH", dirname(__FILE__));

// Include All Configuration Files
include_once SSF_ABSPATH."/Configuration/SecureFormDatabaseConfiguration.php";
include_once SSF_ABSPATH."/Configuration/UpdaterConfiguration.php";

// Include all the classes
include_once SSF_ABSPATH."/FunctionSets/DBSettings.php";
include_once SSF_ABSPATH."/FunctionSets/SSF_Router.php";

// Include the URL Handler to verify the URL and the request.
include_once SSF_ABSPATH."/URLHandler.php";

// Include the router file to route the URLs
include_once SSF_ABSPATH."/router.php";

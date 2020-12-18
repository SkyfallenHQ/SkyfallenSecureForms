<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301009                                  */
/* This file is where all requests are redirected to. All file inclusions are here.*/
/***********************************************************************************/

// Define the application's ABSOLUTE FS Path
define("SSF_ABSPATH", dirname(__FILE__));

// Include All Configuration Files
include_once SSF_ABSPATH."/Configuration/UpdaterConfiguration.php";
include_once SSF_ABSPATH."/thisversion.php";


// Unless the installation was complete, the Database Config should exist, if not, run the install.
if((@include_once SSF_ABSPATH . "/Configuration/SecureFormDatabaseConfiguration.php") === false){
    // Include the install file
    include_once SSF_ABSPATH."";
    die();
}


// Include all the classes
include_once SSF_ABSPATH."/FunctionSets/DBSettings.php";
include_once SSF_ABSPATH."/FunctionSets/SSF_Router.php";

// Include the URL Handler to verify the URL and the request.
include_once SSF_ABSPATH."/URLHandler.php";

// Include the router file to route the URLs
include_once SSF_ABSPATH."/router.php";

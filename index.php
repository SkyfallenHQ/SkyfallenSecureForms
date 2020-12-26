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
include_once SSF_ABSPATH."/Configuration/UpdaterConfiguration.php";
include_once SSF_ABSPATH."/thisversion.php";


// Unless the installation was complete, the Database Config should exist, if not, run the install.
if((@include_once SSF_ABSPATH . "/Configuration/SecureFormDatabaseConfiguration.php") === false){

    // Include the install file
    include_once SSF_ABSPATH."/Configuration/install.php";

    // Stop further execution
    die();
}

// Include Helpers
include_once SSF_ABSPATH."/SSF_Includes/UserSession_Helper.php";
include_once SSF_ABSPATH."/SSF_Includes/CSRF_Session_Helper.php";
include_once SSF_ABSPATH."/SSF_Includes/RSA_Helper.php";

// Include all of SSF_Includes
include_once SSF_ABSPATH."/SSF_Includes/utility_functions.php";

// Include all the classes
include_once SSF_ABSPATH."/FunctionSets/DBSettings.php";
include_once SSF_ABSPATH."/FunctionSets/SSF_Router.php";
include_once SSF_ABSPATH."/FunctionSets/SSF_CSRF.php";
include_once SSF_ABSPATH."/FunctionSets/SSFUser.php";
include_once SSF_ABSPATH."/FunctionSets/SSF_Form.php";
include_once SSF_ABSPATH."/FunctionSets/SSF_FormField.php";


// Include all RSA Libraries
include_once SSF_ABSPATH."/DataSecurity/RSA_Libraries/vendor/autoload.php";

// Include the URL Handler to verify the URL and the request.
include_once SSF_ABSPATH."/URLHandler.php";

// Include the router file to route the URLs
include_once SSF_ABSPATH."/router.php";

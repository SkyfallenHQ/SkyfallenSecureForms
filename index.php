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
define("SSF_ABSPATH",getcwd());

// Define the request url according to the current request.
define("REQUEST",$_GET["path"]);

// Include All Configuration Files
include_once SSF_ABSPATH."/Configuration/SecureFormDatabaseConfiguration.php" or die("Missing Database Configuration");
include_once SSF_ABSPATH."/Configuration/UpdaterConfiguration.php" or die("Missing Updater Configuration");

// Include all the classes
include_once SSF_ABSPATH."/FunctionSets/DBSettings.php";
include_once SSF_ABSPATH."/FunctionSets/SSF_Router.php";

// Include the router file
include_once SSF_ABSPATH."/router.php";

<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301100                                  */
/*         This file defines constants based on user's session data                */
/***********************************************************************************/

// Check if our ABSPATH is defined
defined("SSF_ABSPATH") or die("Don't mess!");

// Name our session
session_name("SecureFormSession");

// Start our session
session_start();

// Check if we are logged in
if(isset($_SESSION["loggedin"]) && isset($_SESSION["username"])){

    // We are logged in.
    define("ISLOGGEDIN",true);

    // Define user data as constants.
    define("USERNAME",$_SESSION["username"]);

} else {

    // We are not logged in.
    define("ISLOGGEDIN",false);
}
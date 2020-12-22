<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301070                                  */
/*           This file prepares the session for use of CSRF Tokens                 */
/***********************************************************************************/

// Check if called from the main file
defined("SSF_ABSPATH") or die("Ouch.");

// Check if SESSION has CSRF started

if(!isset($_SESSION["csrf_codes"])){

    // We are not ready to handle CSRF Functions
    // Initialize an empty array

    $_SESSION["csrf_codes"] = array();

}
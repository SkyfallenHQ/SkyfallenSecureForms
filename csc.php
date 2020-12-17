<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                     csc.php - Create Server Config                              */
/*                         File Since: SFR-301002                                  */
/*  This file rename the ApacheHtaccess file to be affective on the first install  */
/***********************************************************************************/

// Open .htaccess File in Writeable Mode, Stop execution otherwise to notify the user to do this manually.
$f = fopen(".htaccess", "a+") or die("SecureForms could not open .htaccess file. Please manually rename ApacheHtaccess to .htaccess in the document root.");

// Open the ApacheHtaccess File in Read-Only Mode
$f2 = fopen("ApacheHtaccess", "r");

// Write the contents of the ApacheHtaccess to real .htaccess
fwrite($f, fread($f2, filesize("ApacheHtaccess")));

// Close both files
fclose($f);
fclose($f2);

// Delete ApacheHtaccess
unlink("ApacheHtaccess");
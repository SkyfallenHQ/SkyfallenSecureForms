<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301009                                  */
/*      This file is where all URL Requests are translated to in-app paths.        */
/***********************************************************************************/


// Prevent direct execution of the file
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
$web_url = DBSettings::getKeyValue("WEB_URL");

// Make Sure WEB_URL ends with '/'
if(substr($web_url,-1) != "/"){
    // Resave the url with trailing slash at the end
    DBSettings::setKey("WEB_URL",$web_url."/");
}

// Define the WEB_URL
define("WEB_URL",DBSettings::getKeyValue("WEB_URL"));

// Try to extract data from our WEB_URL

// Seperate the web_url to parts by '/'
$subfolders = explode("/",WEB_URL);
$s_subfolders = array();
$i = 0;

$rootDomain = $subfolders[2];

$protocol = $subfolders[0];

// Define the domain name
define("ROOT_DOMAIN",$rootDomain);


// Check if SSL is enabled
if($protocol = "http:"){
    define("IS_SSL",false);
} elseif($protocol = "https:") {
    define("IS_SSL",true);
}

// Iterate through each part and get rid of first two
foreach ($subfolders as $subfolder){
    if($i > 2){
        array_push($s_subfolders,$subfolder);
    }
    $i = $i+1;
}
unset($i);

$subdir = "";

foreach ($s_subfolders as $s_subfolder){
    $subdir = $subdir."/".$subfolder;
}

// Add / to the end
$subdir = $subdir."/";

// Define the sub-directory
define("SSF_SUBDIR",$subdir);

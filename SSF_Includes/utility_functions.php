<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301061                                  */
/*   This file contains some utility functions that help with the development.     */
/***********************************************************************************/

// Check if called from the main file
defined("SSF_ABSPATH") or die("Stop it!");

/**
 * Echos the WEB_URL of current application
 */
function the_weburl(){
    echo WEB_URL;
}

/**
 * Echos the url concatenated with an page's url
 * @param String $path Path to the page
 */
function the_pageurl($path){
    echo WEB_URL.$path;
}

/**
 * Echos the url concatenated with an asset's url
 * @param String $path Path to the url inside the app
 */
function the_fileurl($path){
    echo WEB_URL.$path;
}

/**
 * Echos the links required for standard input styles
 */
function link_std_inputs(){
    ?>
    <link href="<?php the_fileurl("static/standard-input/css/std-inputs.css?rev=5"); ?>" rel="stylesheet" type="text/css">
    <?php
}

/**
 * Echos the links required for fontawesome
 */
function link_fa_icons(){
    ?>
    <link href="<?php the_fileurl("static/fontawesome/css/all.min.css"); ?>" rel="stylesheet" type="text/css">
    <?php
}

/**
 * Redirects the user using headers
 * @param String $to The path after the domain to redirect to
 */
function ssf_redirect($to){
    header("location: ".WEB_URL.$to);
}

/**
 * Generates a random MD5 Hash
 * @return String Hash
 */
function rand_md5_hash(){
    return md5(uniqid(rand(), true));
}
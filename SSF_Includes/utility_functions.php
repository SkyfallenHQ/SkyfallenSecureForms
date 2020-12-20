<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301061                                  */
/*   This file contains some utility functions that help with the development.     */
/***********************************************************************************/

/**
 * Echos the WEB_URL of current application
 */
function the_weburl(){
    echo WEB_URL;
}

/**
 * Echos the url concatenated with an asset's url
 * @param String $path Path to the url inside the app
 */
function the_fileurl($path){
    echo WEB_URL.$path;
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
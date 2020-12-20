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
 * Echos the WEB URL of current application
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

<?php
/**
 * Class SSF_Router
 * Handles url routing
 */

class SSF_Router
{
    /**
     * Routes a specific path to a function
     * @param String $path The path to route
     * @param String $func The function to route to
     * @param Boolean $requireLogin Do we need to login to access this page
     * @param String $fallbackfunc The function to route to if we are not logged in
     */
    public static function routePage($path, $func,$requireLogin = false, $fallbackfunc = "null"){
        if($requireLogin) {
            if(ISLOGGEDIN) {
                if (REQUEST == $path or REQUEST == $path . "/") {
                    $func();
                }
            } else {
                $fallbackfunc();
            }
        }
        else {
            if (REQUEST == $path or REQUEST == $path . "/") {
                $func();
            }
        }
    }

    /**
     * Routes urls with a specific beginning to a function
     * @param String $prefix Prefix to look for
     * @param String $func Function to redirect to
     * @param Boolean $noEndTrailingSlash Remove trailing slash from the remaining path
     * @param Boolean $requireLogin Decides whether user should be logged in to view this page
     * @param String $fallbackfunc What to do if user is not logged in, name of a function
     */
    public static function routePrefix($prefix,$func,$noEndTrailingSlash = false,$requireLogin = false, $fallbackfunc = "null"){
        if(substr(REQUEST,0,strlen($prefix)) == $prefix."/"){
                $remainingPath = "";
                if($noEndTrailingSlash && substr(REQUEST,strlen(REQUEST)-2,strlen(REQUEST)-1) == "/"){
                    $remainingPath = substr(REQUEST,strlen($prefix),strlen(REQUEST)-2);
                }
                $func($remainingPath);
        }
    }
}
<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301101                                  */
/*             This file contains functions to handle binary data                  */
/***********************************************************************************/

// Check if we are called from the main process
defined("SSF_ABSPATH") or die("Screw It!");

/**
 *  Converts Binary Data to human readable Strings
 * @param String $binary Binary Input
 * @return string|null String Text
 */
function binaryToString($binary)
{
    $binaries = explode(' ', $binary);

    $string = null;
    foreach ($binaries as $binary) {
        $string .= pack('H*', dechex(bindec($binary)));
    }

    return $string;
}
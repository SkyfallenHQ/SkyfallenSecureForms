<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301009                                  */
/*                This file handles the installation process                       */
/***********************************************************************************/

// Check if called from the main install file
defined("SSF_ABSPATH") or die("Nope! We have thought of that before you did!");

?>
<html>
    <head>
        <title>Skyfallen Secure Forms: INSTALLATION</title>
        <style>
            .install-wrapper{
                width: 40%;
                min-width: 500px;
                height: 40%;
                min-height: 400px;
            }
        </style>
    </head>

    <body>
        <div class="install-wrapper">
            <form id="database-options" class="options-form">
                <button type="submit" name="save">Save</button>
            </form>
        </div>
    </body>
</html>

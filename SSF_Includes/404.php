<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301048                                  */
/*                     This file is renders a 404 page                             */
/***********************************************************************************/

// Check if ABSPATH was defined
defined("SSF_ABSPATH") or die("Hehehe. Funny.");

// HTML Code for rendering the 404 page
?>
<html>
    <head>
        <title>This page was not found.</title>
        <link href="<?php the_fileurl("static/css/four-o-four.css"); ?>" rel="stylesheet" type="text/css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@200&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="basic-wrapper-01">
            <h1 id="404">404</h1>
            <h6 id="404-explanation">We weren't able to find that page.</h6>
        </div>
    </body>
</html>

<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301006                                  */
/*              This file handles the in-app update function                       */
/***********************************************************************************/

// Include Updater Configuration
require_once "Configuration/UpdaterConfiguration.php";

// Check if Session is already open otherwise create a new one.
if(session_status() == PHP_SESSION_NONE) {
    session_name("SecureFormsSession");
    session_start();
} else {
    // Make sure we are logged in and update s authorised.
    if (!$_SESSION["loggedin"] and isset($_SESSION["UPDATE_AUTHORIZED"]) and $_SESSION["UPDATE_AUTHORIZED"] == "TRUE") {
        // Redirect to / if not.
        header("Location: /");
    }
}
/**
 *  Deletes a folder recursively excluding Configuration and RSA Key Directories
 *  @param String $dir Path to folder to delete
 *  @param bool $rmitself Decides whether the folder itself should be deleted or not
 */

function rrmdir($dir,$rmitself = true) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != ".." && $object != "DataSecurity" && $object != "Configuration") {
                if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                    rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        if($rmitself) {
            rmdir($dir);
        }
    }
}
// If update is authorised with correct values
if(isset($_SESSION["UPDATE_AUTHORIZED"]) and $_SESSION["UPDATE_AUTHORIZED"] == "TRUE") {

    // Include UC Connector API Library
    include_once "SkyfallenCodeLib/UpdatesConsoleConnector.php";

    // Remove everything in current directory
    rrmdir(getcwd(),false);

    // Show updating page
    ?>
    <div class="sys-upgrade-wrap">
        <div class="sys-upgrade-animation">
        </div>
        <section class="sys-upgrade-text">
            <h3>SecureForms is upgrading...</h3>
            <p>It will be over in a few seconds.</p>
            <p>Get ready for a better SecureForms Experience!<p>
                <footer>In case of a problem, <a href="https://help.theskyfallen.com">get help</a>.
        </section>
    </div>
    <style>
        body {
            font-family: "Consolas","Monaco","Ubuntu Mono",monospace !important;
            background: #4D4E6A;
            color: #fff;
        }

        .sys-upgrade-wrap {
            margin: 20vh auto;
            width: 500px;
        }

        .sys-upgrade-animation {
            background-image: url("data:image/png;base64,\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\a");
            background-size: 72px auto;
            background-repeat: no-repeat;
            background-position: center center;
            width: 80px;
            height: 80px;
            position: relative;
            float: left;
            margin-top: 68px;
            margin-right: 20px;
        }
        .sys-upgrade-animation:before, .sys-upgrade-animation:after {
            content: "";
            display: block;
            position: absolute;
            background-image: url("data:image/png;base64,\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\a");
            background-size: 72px auto;
            background-repeat: no-repeat;
            background-position: center center;
            width: 80px;
            height: 80px;
        }
        .sys-upgrade-animation:before {
            top: -40px;
            animation: upgrading 2s 2s ease-in infinite alternate;
            -webkit-animation: upgrading 2s 2s ease-in infinite alternate;
        }
        .sys-upgrade-animation:after {
            top: -80px;
            animation: upgrading 2s ease-in infinite alternate;
            -webkit-animation: upgrading 2s ease-in infinite alternate;
        }

        @keyframes upgrading {
            from {
                opacity: 0.2;
            }
            to {
                opacity: 1;
            }
        }
        @-webkit-keyframes upgrading {
            from {
                opacity: 0.3;
            }
            to {
                opacity: 1;
            }
        }
        .sys-upgrade-text h3 {
            font-size: 24px;
        }
        .sys-upgrade-text p {
            color: #AAAED8;
        }
        .sys-upgrade-text footer {
            font-size: 12px;
            color: #999;
        }
        .sys-upgrade-text footer a {
            color: #ccc;
        }

    </style>
    <?php
    // Download the update package
    $ret = \SkyfallenCodeLibrary\UpdatesConsoleConnector::downloadLatestVersion(UC_API_APPID,UC_API_APPSEED,UC_API_ENDPOINT,"");
    // Continue if success
    if($ret["success"]) {
        // Extract the update package
        if(\SkyfallenCodeLibrary\UpdatesConsoleConnector::installUpdate($ret["path"],getcwd())){

            // If exists, run csc.php to setup .htaccess
            if(file_exists("csc.php")){
                include_once "csc.php";
                unlink("csc.php");
            }

            // If exists, run post-update script
            if(file_exists("onupdate.php")){
                include_once "onupdate.php";
                unlink("onupdate.php");
            }

            // Include a timeout in html code to redirect.
            ?>
            <script>
                window.setTimeout(function(){
                    window.location.href = "/";

                }, 5000);
            </script>
            <?php

            // Delete Update Package
            unlink($ret["path"]);

            // Deauthorize updates till next session.
            $_SESSION["UPDATE_AUTHORIZED"] = false;
        }else
        {
            // Error, Failed to unpack update zip
            echo "<p style='text-align: center;'>Failed to unpack update.</p>";
        }
    }else {
        // Error, Failed to download update zip
        echo "<p style='text-align: center;'>Failed to download update from the server.</p>";
    }
}

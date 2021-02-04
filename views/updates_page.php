<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301120                                  */
/*         This file is used for rendering the system updates page                 */
/***********************************************************************************/

/**
 * This function renders the software update page.
 */
function render_updates_page() {

    $provider_info = \SkyfallenCodeLibrary\UpdatesConsoleConnector::getProviderData(UC_API_ENDPOINT);
    $new_vname = \SkyfallenCodeLibrary\UpdatesConsoleConnector::getLatestVersion(UC_API_APPID,UC_API_APPSEED,UC_API_ENDPOINT);
    $new_version_data = \SkyfallenCodeLibrary\UpdatesConsoleConnector::getLatestVersionData(UC_API_APPID,UC_API_APPSEED,UC_API_ENDPOINT);
    $user = new SSFUser(USERNAME);
    if($user->role != "SUPERUSER"){
        include_once SSF_ABSPATH."/SSF_Includes/404.php";
        die();
    }
    ?>
<html>
    <head>
        <title>Skyfallen SecureForms: Software Update</title>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/updates-page.css"); ?>">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    </head>

    <body>
    <div class="infowrap">
    <h1 class="app-branding">SecureForms by Skyfallen</h1>
    <h3 class="rel-id"><?php echo THIS_VERSION_NICKNAME." (".THIS_VERSION_BRANCH." ".THIS_VERSION.")"; ?></h3>
        <hr>
        <div class="new-version-info">
    <?php
    if (THIS_VERSION != $new_vname){
        if(isset($_GET["install"])) {
            if ($_GET["install"] == "start") {
                $_SESSION["UPDATE_AUTHORIZED"] = "TRUE";
                ssf_redirect("SoftwareUpdater.php");
            }
        }
        ?>
        <div class="text-center">
            <h3>Updates are available:</h3>
        </div>
        <div class="update-details">
            <div class="update-details-padded-container">
                <h4><?php echo $new_version_data["title"]; ?> (<?php echo $new_version_data["version"]; ?>) </h4>
                <h4>Release Date:<?php echo $new_version_data["releasedate"]; ?></h4>
                <h5>Description:<br><?php echo $new_version_data["description"]; ?></h5>
            </div>
        </div>
        <div class="text-center">
            <a href="?install=start" class="update-btn">Update</a>
        </div>
        <?php


    }
    else {
        echo "<div class='noupdates-container'><p class='noupdates'>You are up to date.</p></div>";
    }
    ?>
        </div>
    <hr>
        <div class="provider-info">
            <div class="provider-info-text">
                <h4>This SecureForms instance's software updates are externally managed by<br> <a href="<?php echo $provider_info["url"] ?>"><?php echo $provider_info["name"]; ?></a></h4>
                <h6><small><?php echo THIS_VERSION; ?> - <?php echo "Current Version's Provider: ".VERSION_PROVIDER; ?></small></h6>
            </div>
        </div>
    </div>
    </body>
</html>
<?php
}

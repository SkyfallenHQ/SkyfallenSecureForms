<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301110                                  */
/*      This file creates a RSA Key for the current user if there is none.         */
/***********************************************************************************/

// Check if called from main process
defined("SSF_ABSPATH") or die("Hmmmm...");

// Check if key file exists for the current user
if(ISLOGGEDIN && !file_exists(SSF_ABSPATH."/DataSecurity/RSA_KEYS/".USERNAME."-key.php")){

    // Increase the time limit so that we don't fail while creating the key
    set_time_limit (3600);

    // Check if OPENSSL is available on this system.
    if (function_exists('openssl_pkey_new')) {

        ob_start();

        echo '
        <html>
          <head>
              <style>
                  body {
				
                        color: white; 
                        font-family: sans-serif;
                        transition: background-color 10s cubic-bezier(1, 1, 1, 1);
                        text-align: center;
                        transition-delay: 0s;
                        padding-top: 10%;
                        
                    }
                    
                    h2 {
                        
                        display: block;
                        
                    }
                    
                    h3 {
                        
                        display: block;
                        
                    }

              </style>
              <script>
              document.onreadystatechange = ()=> {
                var colors = ["red", "orange", "yellow", "green", "blue", "purple"];
                var currentIndex = 0;

                document.body.style.cssText = "background-color: " + colors[currentIndex];
	            currentIndex++;
	            if (currentIndex == undefined || currentIndex >= colors.length) {
		            currentIndex = 0;
                }

                setInterval(function() {
	                document.body.style.cssText = "background-color: " + colors[currentIndex];
	                currentIndex++;
	                if (currentIndex == undefined || currentIndex >= colors.length) {
		                currentIndex = 0;
	                }
                }, 5000);
	            }
                </script>
          </head>
          <body>
              <h2>Creating a new RSA Key for your account. This will take a moment. You will be automatically redirected when done.</h2><br>
              <h3>OpenSSL is available. This process is expected to be completed within a few seconds.</h3>
          </body>
      </html>';

        ob_end_flush();

        @ob_flush();

        flush();

        // Files doesn't exist, so create a new keypair.
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        // Create the private and public key
        $res = openssl_pkey_new($config);

        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

        // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];

        // Open the key file
        $keyFile = fopen(SSF_ABSPATH."/DataSecurity/RSA_KEYS/".USERNAME."-key.php","w+");

        // Create a valid PHP Syntax
        $phpKeyFileText = "<?php define('".USERNAME."-PRIVATEKEY','".$privKey."'); \n define('".USERNAME."-PUBLICKEY','".$pubKey."');";

        // Write the key to the file
        fwrite($keyFile,$phpKeyFileText);

        echo '<script>window.location.reload()</script>';
        ob_flush();
        flush();


    } else {

    ob_start();

    echo '<html>
          <head>
              <style>
                  body {
				
                        color: white; 
                        font-family: sans-serif;
                        transition: background-color 10s cubic-bezier(1, 1, 1, 1);
                        text-align: center;
                        transition-delay: 0s;
                        padding-top: 10%;
                        
                    }
                    
                    h2 {
                        
                        display: block;
                        
                    }
                    
                    h3 {
                        
                        display: block;
                        
                    }
              </style>
              <script>
                document.onreadystatechange = ()=> {
                var colors = ["red", "orange", "yellow", "green", "blue", "purple"];
                var currentIndex = 0;

                document.body.style.cssText = "background-color: " + colors[currentIndex];
	            currentIndex++;
	            if (currentIndex == undefined || currentIndex >= colors.length) {
		            currentIndex = 0;
                }

                setInterval(function() {
	                document.body.style.cssText = "background-color: " + colors[currentIndex];
	                currentIndex++;
	                if (currentIndex == undefined || currentIndex >= colors.length) {
		                currentIndex = 0;
	                }
                }, 5000);
	            }
            </script>
          </head>
          <body>
              <h2>Creating a new RSA Key for your account. This will take a moment. You will be automatically redirected when done.</h2><br>
              <h3>OpenSSL is not available on your system. Process will take a lot longer than usual. More information about the progress will not be available.</h3>
          </body>
      </html>';

    ob_end_flush();

    @ob_flush();

    flush();

    // Create a new keypair
    $privKey = \phpseclib3\Crypt\RSA::createKey(2048);
    $pubKey = $privKey->getPublicKey();

    // Open the key file
    $keyFile = fopen(SSF_ABSPATH."/DataSecurity/RSA_KEYS/".USERNAME."-key.php","w+");

    // Create a valid PHP Syntax
    $phpKeyFileText = "<?php define('".USERNAME."-PRIVATEKEY','".$privKey."'); \n define('".USERNAME."-PUBLICKEY','".$pubKey."');";

    // Write the key to the file
    fwrite($keyFile,$phpKeyFileText);

    echo '<script>window.location.reload()</script>';
    ob_flush();
    flush();
    }
}
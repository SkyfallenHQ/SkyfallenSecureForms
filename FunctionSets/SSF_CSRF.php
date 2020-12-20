<?php

/**
 * Class SSF_CSRF
 * Creates CSRF Tokens for Forms
 */
class SSF_CSRF
{
    /**
     * @var String $CSRF_ID Stores the CSRF Token's ID that we are using
     */
    private $CSRF_ID;

    /**
     * @var String $CSRF_TOKEN Stores the CSRF Token that we are using
     */
    private $CSRF_TOKEN;

    /**
     * SSF_CSRF constructor.
     * Creates a new CSRF Token
     */
    public function __construct(){

        $this->CSRF_ID = rand_md5_hash();

        $this->CSRF_TOKEN = rand_md5_hash();

        $_SESSION["csrf_codes"][$this->CSRF_ID] = $this->CSRF_TOKEN;
    }

    /**
     * Checks if the CSRF from the form is valid.
     * @return bool false if invalid CSRF, true on valid CSRF
     */
    public static function verifyCSRF(){

        $form_csrf_id = $_POST["csrf_id"];

        $form_csrf_token = $_POST["csrf_token"];

        if(@$_SESSION["csrf_codes"][$form_csrf_id] == $form_csrf_token){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Renders two hidden inputs containing CSRF Tokens
     */
    public function put(){
        ?>
            <input type="password" value="<?php echo $this->CSRF_ID ?>" name="csrf_id" hidden>
            <input type="password" value="<?php echo $this->CSRF_TOKEN ?>" name="csrf_token" hidden>
        <?php
    }

    /**
     * Clears out all previous CSRF Tokens
     */
    public static function clearTokens(){

        $_SESSION["csrf_codes"] = array();

    }
}
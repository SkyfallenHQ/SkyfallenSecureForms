<?php

/**
 * Class DBSettings
 * Controls the Settings Table in the MYSQL Database
 */

class DBSettings
{
    /**
     * Deletes a key from the Settings Table
     * @param String $keyname
     */
    public static function deleteKey($keyname){
        $stmt = $connection->stmt_init();
        $stmt->prepare("DELETE FROM ssf_settings WHERE setting=?");
        $stmt->bind_param("s",$keyname);
        $stmt->exec();
    }

    /**
     * Sets a value for the given key in the Settings Database
     * @param String $keyname
     * @param String $keyvalue
     */
    public static function setKey($keyname,$keyvalue){
        $stmt = $connection->stmt_init();
        $stmt->prepare("SELECT setting FROM ssf_settings WHERE setting=?");
        $stmt->bind_param("s",$keyname);
        $res = $stmt->get_result();
        $numrows = $res->num_rows();
        $res->free();
        $stmt->close();


        if($numrows == 1){
            $delete_stmt = $connection->stmt_init();
            $delete_stmt->prepare("DELETE FROM ssf_settings WHERE setting=?");
            $delete_stmt->bind_param("s",$keyname);
            $delete_stmt->exec();
            $delete_stmt->close();
        }

        $addval_stmt = $connection->stmt_init();
        $addval_stmt->prepare("INSERT INTO ssf_settings (setting,value) VALUES (?,?)");
        $addval_stmt->bind_param("ss",$keyname,$keyvalue);
        $addval_stmt->exec();
        $addval_stmt->close();
    }

    /**
     * Fetches a key's value from the Settings Table
     * @param String $keyname
     */
    public static function getKeyValue($keyname){
        $value = "";
        $stmt = $connection->stmt_init();
        $stmt->prepare("SELECT value FROM ssf_settings WHERE setting=?");
        $stmt->bind_param("s",$keyname);
        $stmt->exec();
        $res = $stmt->get_result();
        if($res->num_rows() == 0){
            $res->free();
            $stmt->close();
            return false;
        } else {
            while($row = $res->fetch_assoc()){
                $value = $row["value"];
            }
            $res->free();
            $stmt->close();
            return $value;
        }
    }
}
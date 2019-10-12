<?php
namespace vbelkin\a2\model;

use mysqli;

/**
 * Class Model
 *
 * @package vbelkin
 * @author  Vitaly Belkin <belkin.jr.nvk@gmail.com>
 */
class Model
{
    protected $db;

    public function __construct()
    {
        $envs = getenv();
        $dbhost = $envs['MYSQL_HOST'];
        $dbName = $envs['MYSQL_DATABASE'];
        $dbUser = $envs['MYSQL_USER'];
        $dbPass = $envs['MYSQL_PASSWORD'];
        try {
            $this->db = new mysqli(
                $dbhost,
                $dbUser,
                $dbPass
            );

            if (!$this->db) {

                // can't connect to MYSQL???
                // handle it...
                throw new connectionException("cannot connect to the database", 0, null);
            }

        }
        catch (connectionException $e) {
            echo $e->displayError();
        }

        //----------------------------------------------------------------------------
        // This is to make our life easier
        // Create your database and populate it with sample data
        $this->db->query("CREATE DATABASE IF NOT EXISTS $dbName;");

        if (!$this->db->select_db($dbName)) {
            // somethings not right.. handle it
            error_log("Mysql database not available!", 0);
        }

        $result = $this->db->query("SHOW TABLES LIKE 'account';");

        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE `account` (
                                          `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
                                          `name` varchar(256) DEFAULT NULL,
                                          PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account", 0);
            }

            if (!$this->db->query(
                "INSERT INTO `account` VALUES (NULL,'Bob'), (NULL,'Mary');"
            )) {
                // handle appropriately
                error_log("Failed creating sample data!", 0);
            }
        }
        //----------------------------------------------------------------------------
    }
}

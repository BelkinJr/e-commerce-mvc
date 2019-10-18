<?php
namespace vbelkin\a3\model;

use mysqli;

/**
 * Class Model
 *
 * @package vbelkin/a3
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
        $this->db->query("flush privileges;");

        //----------------------------------------------------------------------------
        // This is to make our life easier
        // Create your database and populate it with sample data
        $this->db->query("CREATE DATABASE IF NOT EXISTS $dbName;");

        if (!$this->db->select_db($dbName)) {
            // somethings not right.. handle it
            error_log("Mysql database not available!", 0);
        }

        //**********user table*********************************************
        $result = $this->db->query("SHOW TABLES LIKE 'account';");

        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE `account` (id int(8) unsigned NOT NULL AUTO_INCREMENT,                         
                                          name varchar(256),
                                          username varchar(256) UNIQUE,
                                          email varchar (256) UNIQUE ,
                                          password varchar (256),
                                          PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account", 0);
            }

            if (!$this->db->query(
                "INSERT INTO `account` VALUES (NULL,'Tim Taylor', 'TheToolman', 'tim.taylor@gmail.com', 'TheToolman');"
            )) {
                // handle appropriately
                error_log("Failed creating sample data!", 0);
            }
        }
        //----------------------------------------------------------------------------
        //******************category table***************************
//        $result = $this->db->query("SHOW TABLES LIKE 'category';");
//
//        if ($result->num_rows == 0) {
//            // table doesn't exist
//            // create it and populate with sample data
//
//            $result = $this->db->query(
//                "CREATE TABLE `category` (
//                                          name varchar(256) NOT NULL UNIQUE,
//                                          PRIMARY KEY (name) );"
//            );
//
//            if (!$result) {
//                // handle appropriately
//                error_log("Failed creating table category", 0);
//            }
//
//            if (!$this->db->query(
//                "INSERT INTO `category` VALUES ('Hammers'), ('Screwdrivers'), ('Cutting Tools'), ('Tool Boxes');"
//            )) {
//                // handle appropriately
//                error_log("Failed creating sample data!", 0);
//            }
//        }
//        //******************item table***************************
//        $result = $this->db->query("SHOW TABLES LIKE 'item';");
//
//        if ($result->num_rows == 0) {
//            // table doesn't exist
//            // create it and populate with sample data
//
//            $result = $this->db->query(
//                "CREATE TABLE `item` (
//                                          id int(8) unsigned NOT NULL AUTO_INCREMENT,
//                                          name varchar(256),
//                                          category varchar(256),
//                                          price int (10),
//                                          FOREIGN KEY (category) REFERENCES category(name),
//                                          PRIMARY KEY (id)
//                                          );"
//            );
//
//            if (!$result) {
//                // handle appropriately
//                error_log("Failed creating table item", 0);
//            }
//
//            if (!$this->db->query(
//                "INSERT INTO `item` VALUES (NULL, 'Small Hammer', 'Hammers', '10'),
//                                                (NULL, 'Small Screwdriver','Screwdrivers', '5'),
//                                                (NULL, 'Small Saw', 'Cutting Tools', '10'),
//                                                (NULL, 'Small Box', 'Tool Boxes', '20'),
//                                                (NULL, 'Big Hammer', 'Hammers', '20'),
//                                                (NULL, 'Very Big Hammer', 'Hammers', '25')
//                                                (NULL, 'Big Screwdriver', 'Screwdrivers', '15'),
//                                                (NULL, 'Chainsaw', 'Cutting Tools', '30')
//                                                (NULL, 'Knife', 'Cutting Tools', '26')
//                                                (NULL, 'Big Box', 'Tool Boxes', '27');"
//            )) {
//                // handle appropriately
//                error_log("Failed creating sample data!", 0);
//            }
//        }
    }
}

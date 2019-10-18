<?php
namespace vbelkin\a3\model;

/**
 * Class AccountModel
 *
 * @package vbelkin/a3
 * @author  Vitaly Belkin <belkin.jr.nvk@gmail.com>
 */
class AccountModel extends Model
{
    /**
     * @var integer Account ID
     */
    private $id;
    /**
     * @var string Account Name
     */
    private $name;


    /**
     * @return int Account ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string Account Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name Account name
     *
     * @return $this AccountModel
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Loads account information from the database
     *
     * @param int $id Account ID
     *
     * @return $this AccountModel
     */
    public function load($id)
    {
        if (!$result = $this->db->query("SELECT * FROM `account` WHERE `id` = $id;")) {
            // throw new ...
        }

        $result = $result->fetch_assoc();
        $this->name = $result['name'];
        $this->id = $id;

        return $this;
    }

    /**
     * Saves account information to the database
     *
     * @return $this AccountModel
     */
    public function save()
    {
        $name = $this->name ?? "NULL";
        if (!isset($this->id)) {
            // New account - Perform INSERT
            try {
                if (!$result = $this->db->query("INSERT INTO `account` VALUES (NULL,'$name');")) {
                    // throw new ...
                    throw new connectionException("cannot connect to the database", 0, null);
                }
            }
            catch (connectionException $e) {
                echo $e->displayError();
            }
            $this->id = $this->db->insert_id;
        } else {
            try {
                // saving existing account - perform UPDATE
                if (!$result = $this->db->query("UPDATE `account` SET `name` = '$name' WHERE `id` = $this->id;")) {
                    // throw new ...
                    throw new connectionException("cannot connect to the database", 0, null);
                }
            }
            catch (connectionException $e) {
                echo $e->displayError();
            }
        }

        return $this;
    }

    /**
     * Deletes account from the database
     *
     * @return $this AccountModel
     */
    public function delete()
    {
        try {
            if (!$result = $this->db->query("DELETE FROM `account` WHERE `account`.`id` = $this->id;")) {
                //throw new ...
                throw new connectionException("cannot connect to the database", 0, null);
            }

            return $this;
        }
        catch (connectionException $e) {
            echo $e->displayError();
        }
    }
}

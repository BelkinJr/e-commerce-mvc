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
     * @var string Account Username
     */
    private $username;
    /**
     * @var string Account email
     */
    private $email;
    /**
     * @var string Account Password
     */
    private $password;


    /**
     * @return int Account ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int Account Username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return int Account Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int Account Password
     */
    public function getPassword()
    {
        return $this->password;
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
     * @param string $email
     * @return $this AccountModel
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $username
     * @return $this AccountModel
     */
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $password
     * @return $this AccountModel
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

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
        $username = $this->username ?? "NULL";
        $email = $this->email ?? "NULL";
        $password = $this->password ?? "NULL";
        $hash = hash('sha512',$password);


        if (!isset($this->id)) {
            // New account - Perform INSERT
            try {
                if (!$result = $this->db->query("INSERT INTO `account` VALUES (NULL,'$name','$username','$email',
                            '$hash');")) {
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
     * Checks if username exists in the database
     *
     * @param $username
     * @return bool
     */
    public function checkUsername($username)
    {
        $res_u = $this->db->query("SELECT * FROM account WHERE username='$username'");

        if (mysqli_num_rows($res_u) > 0)
        {
            return 1;
        } else return 0;
    }

    /**
     * Attempt at login
     * checking if user has entered information correctly
     *
     * @param $username
     * @param $password
     * @return bool
     */
    public function loginAttempt($username, $password)
    {

        $hash = hash('sha512',$password);
       $result = $this->db->query("SELECT * FROM account WHERE username='$username' AND password= '$hash'");




        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {return false;}
    }

}

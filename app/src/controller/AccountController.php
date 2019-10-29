<?php
namespace vbelkin\a3\controller;

use vbelkin\a3\model\{AccountModel, AccountCollectionModel};
use vbelkin\a3\view\View;
use vbelkin\a3\helpers\Helpers;

/**
 * Class AccountController
 *
 * @package vbelkin/a3
 * @author  Vitaly Belkin <belkin.jr.nvk@gmail.com>
 */
class AccountController extends Controller
{
    /**
     * Account Index action
     */
    public function indexAction()
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            if (!empty($_POST)) {
                if (isset($_POST["uname"]) && isset($_POST["psw"])) {
                    $username = $_POST["uname"];
                    $password = $_POST["psw"];
                    $account = new AccountModel();
                    if (!$account->loginAttempt($username,$password)) {
                        $view = new View('accountIndex');
                        $view->addData('missing', "make sure your details are correct");
                        echo $view->render();
                    } else {
                        $_SESSION['username'] = $username;
                        $view = new View('homePage');
                        $view->addData('username', $username);
                        echo $view->render();
                    }
                }

            } else {
                $view = new View('accountIndex');
                echo $view->render();
            }
        } else {
            $view = new View('homePage');
            $view->addData('username', $_SESSION['username']);
            echo $view->render();
        }
    }

    /**
     * Account Create action
     * creates the account if the form is not empty
     */
    public function createAction()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $name = $_POST["name"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["psw"];
            $password2 = $_POST["psw-repeat"];

            if (!Helpers::usernameCheck($username))
            {
                $view = new View('accountCreation');
                $view->addData('missing', "username can only have alphanumeric characters");
                echo $view->render();
            }
            elseif (!Helpers::passCheck($password))
            {
                $view = new View('accountCreation');
                $view->addData('missing', "password has to have one lowercase letter, one uppercase letter, one number and no special characters, 7-15 symbols");
                echo $view->render();
            }
            elseif (!Helpers::passMatch($password,$password2))
            {
                $view = new View('accountCreation');
                $view->addData('missing', "passwords do not match");
                echo $view->render();
            }
            else
            {
                $account = new AccountModel();
                $account->setName($name); // will come from Form data
                $account->setEmail($email);
                $account->setUsername($username);
                $account->setPassword($password);
                $account->save();

                $_SESSION['username'] = $username;
                $view = new View('homePage');
                $view->addData('username', $username);
                echo $view->render();
            }
        } else {
            $view = new View('accountCreation');
            echo $view->render();
        }
    }

    /**
     *
     * Checks if username is free
     * sends response to ajax
     */
    public function ifUsernameFree()
    {
        $username = $_POST["username"];
        $account = new AccountModel();
        $response = $account->checkUsername($username);
        $jsonresponse = json_encode($response);
        echo $jsonresponse;
    }


    /**
     * Destroys session
     * and takes user to the index page
     *
     */
    public function accountLogout(){
        session_start();
        session_unset();
        session_destroy();
        $view = new View('accountIndex');
        echo $view->render();
    }
}
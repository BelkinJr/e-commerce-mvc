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
        $view = new View('accountIndex');
        echo $view->render();
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
                //PLACEHOLDER AIGHT
            }
        } else {
            $view = new View('accountCreation');
            echo $view->render();
        }
    }

    /**
     * Account Create Redirect action
     *
     *redirects to the account creation page
     */
    public function createRedirect()
    {

    }

    /**
     * Account Delete action
     *
     * @param int $id Account id to be deleted
     */
    public function deleteAction($id)
    {
        session_start();
        $account = (new AccountModel())->load($id);
        $account->delete();
        $name = $account ->getName();
        $view = new View('accountDeleted');
        echo $view->addData('name', $name)->render();
    }
    /**
     * Account Update action
     *
     * @param int $id Account id to be updated
     */
    public function updateAction($id)
    {
        session_start();
        $account = (new AccountModel())->load($id);
        if (!empty($_POST["name"])) {
            $name = $_POST["name"];
            $account->setName($name)->save(); // new name will come from Form data
            $view = new View('updateSuccess');
            $view->addData('id', $id);
            $view->addData('name', $name);
            echo $view->render();
        } else {
            $name = $account->getName();
            $view = new View('accountUpdate');
            $view->addData('id', $id);
            $view->addData('missing', "account name can't be empty");
            echo $view->addData('name', $name)->render();
        }

    }

    /**
     * Account Update Redirect action
     *
     * @param $id
     */
    public function updateRedirect($id)
    {
        session_start();
        $account = (new AccountModel())->load($id);
        $name = $account ->getName();
        $view = new View('accountUpdate');
        $view->addData('id', $id);
        echo $view->addData('name', $name)->render();
    }

    public function loginAction()
    {


    }


}
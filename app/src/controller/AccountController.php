<?php
namespace vbelkin\a3\controller;

use vbelkin\a3\model\{AccountModel, AccountCollectionModel};
use vbelkin\a3\view\View;

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
        $collection = new AccountCollectionModel();
        $accounts = $collection->getAccounts();
        $view = new View('accountIndex');
        echo $view->addData('accounts', $accounts)->render();
    }
    /**
     * Account Create action
     * creates the account if the form is not empty
     */
    public function createAction()
    {
        if (!empty($_POST["name"]))
        {
            $name = $_POST["name"];
            $account = new AccountModel();
            $account->setName($name); // will come from Form data
            $account->save();
            $id = $account->getId();
            $view = new View('accountCreated');
            echo $view->addData('name', $name)->render();
        } else {
            $view = new View('accountIndex');
            $collection = new AccountCollectionModel();
            $accounts = $collection->getAccounts();
            $view->addData('accounts', $accounts);
            echo $view->addData('missing', "account name can't be empty")->render();
        }
    }

    /**
     * Account Delete action
     *
     * @param int $id Account id to be deleted
     */
    public function deleteAction($id)
    {
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
        $account = (new AccountModel())->load($id);
        $name = $account ->getName();
        $view = new View('accountUpdate');
        $view->addData('id', $id);
        echo $view->addData('name', $name)->render();
    }


}
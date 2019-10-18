<?php
namespace vbelkin\a3\controller;

/**
 * Class HomeController
 *
 * @package vbelkin/a3
 * @author  Vitaly Belkin <belkin.jr.nvk@gmail.com>
 */
class HomeController extends Controller
{
    /**
     * Account Index action
     */
    public function indexAction()
    {
        $this->redirect('accountIndex');
    }
}

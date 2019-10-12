<?php
namespace vbelkin\a2\controller;

/**
 * Class HomeController
 *
 * @package vbelkin
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

<?php
namespace vbelkin\a2\model;

use Throwable;

/**
 * Class connectionException
 *
 * @package vbelkin
 * @author  Vitaly Belkin <belkin.jr.nvk@gmail.com>
 */

class connectionException extends \Exception
{
    private $errorMessage;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function displayError() {
        echo $this->message;
    }

}
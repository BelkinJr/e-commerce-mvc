<?php

namespace vbelkin\a3\helpers;

/**
 * Class Helpers
 *
 * @package veblkin/a3
 * @author  Vitaly Belkin <belkin.jr.nvk@gmail.com>
 */


class Helpers
{
    /**
     * @param $password
     *
     * Check if password meets regex requirements
     * @return bool
     */
    public static function passCheck($password)
    {
        if (preg_match('/^(?=.*[A-Z])(?!.*[^a-zA-Z0-9]).{7,15}$/', $password))
        {
            return true;
        } else {return false;}
    }

    /**
     * @param $password1
     * @param $password2
     *
     * check if password matches repeated password
     * @return bool
     */
    public static function passMatch($password1, $password2)
    {
        if ($password1==$password2)
        {
            return true;
        } else { return false; }
    }

    /**
     * @param $username
     *
     * checks if username has only alphanumerics
     * @return bool
     */
    public static function usernameCheck($username)
    {
        if (preg_match('/^[a-zA-Z0-9]*$/', $username))
        {
            return true;
        } else {return false;}
    }

}
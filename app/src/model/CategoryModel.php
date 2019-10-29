<?php

namespace vbelkin\a3\model;

/**
 * Class CategoryModel
 *
 * @package vbelkin/a3
 * @author  Vitaly Belkin <belkin.jr.nvk@gmail.com>
 */
class CategoryModel extends Model
{
    /**
     * @var string name
     * name of the category
     */
    private $name;

    /**
     * @return string category Name
     */
    public function getName()
    {
        return $this->name;
    }






}
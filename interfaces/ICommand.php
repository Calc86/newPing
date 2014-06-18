<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:53
 */

namespace ping;


interface ICommand {
    /**
     * @return void
     */
    public function execute();
} 
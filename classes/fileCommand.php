<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 10:34
 */

namespace ping;


class fileCommand implements ICommand {
    private $path;
    private $content;

    function __construct($path, $content)
    {
        $this->path = $path;
        $this->content = $content;
    }

    /**
     * @return void
     */
    public function execute()
    {
        file_put_contents($this->path, $this->content);
    }
}

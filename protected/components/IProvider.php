<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 12.08.2014
 * Time: 12:30
 */



interface IProvider{

    public  function parse();

    private function process();

    private function save();

}
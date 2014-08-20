<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 12.08.2014
 * Time: 12:30
 */



interface IProvider{

    /**
     * <code>
     * $return = [
     *   'temp' int
     * ];
     * </code>
     * @return array
     */
    public static function parse($city);

}
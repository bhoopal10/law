<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 17/10/13
 * Time: 10:15 PM
 * To change this template use File | Settings | File Templates.
 */

class User extends Eloquent {
    public function userdetail($any)
    {
        print_r($any);
    }
    public static function getlawyername($id)
    {

    }

}
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 18/10/13
 * Time: 4:52 PM
 * To change this template use File | Settings | File Templates.
 */

class Role
{
    public static function role_by($id)
    {
        $res=User::roleByID($id);
        return $res;
    }

    public static function get_all_roles()
    {
       return Authentication::allRoles();
    }


}
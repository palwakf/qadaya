<?php


namespace App\Helpers;


class Common
{
    public static function getMenu($user){
        $menu = [];
        $user_permissions = $user->getAllPermissions();
        $menu = $user_permissions->where('parent_id', 0);
        foreach ($menu as $k => $menu_item){
            $menu[$k]['children'] = $user_permissions->where('parent_id', $menu_item->id);
        }
        return $menu;
    }
}

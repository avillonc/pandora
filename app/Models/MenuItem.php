<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuItem extends Model
{
    use HasFactory;

    public static function  getItemsByRole()
    {
        //$optionItems = array();
       // dd(session('roles'));
        $roleIds = explode(",", session('roles'));

        if (in_array(1, $roleIds)) //ADMIN
            $authItems = MenuItem::select(DB::RAW('id AS menu_item_id'))->where('enabled', 1)->get()->toArray();
        else {
            //Obtiene los menus de acuerdo a los roles del usuario
            $authItems = Authorization::query()
                ->distinct()
                ->select('menu_item_id')
                ->whereIn('role_id',  $roleIds)
                ->where('enabled', 1)
                ->get()
                ->toArray();
        }

        //dd($authItems);
        $menuItems = MenuItem::where('enabled', "1")
            ->whereIn('id', $authItems)
            ->select(DB::raw("menu_items.*"))->orderBy('sortNum')->get();
        return $menuItems;
       // dd($menuItems);
        /*if ($roleId == 1)
            $authItems = MenuItem::select(DB::RAW('id AS menu_item_id, enabled'))->where('enabled', 1)->get();
        else
            $authItems = Authorization::where('role_id', '=', $roleId)->get();

        foreach ($authItems as $authItem) {
            $optionItems[$authItem->menu_item_id] = $authItem->enabled;
        }

        $menuItems = MenuItem::where('enabled', "1")
            ->select(DB::raw("menu_items.*, false isActive "))->orderBy('sortNum')->get();

        foreach ($menuItems as $menuItem) {
            if (isset($optionItems[$menuItem->id])) {
                $menuItem->option = $optionItems[$menuItem->id];
                if ($menuItem->isItem == 0) {
                    unset($menuItem->to);
                }
            }
        }

        $menuItems = $menuItems->filter(function ($item) {
            return $item->option > 0;
        })->values();

        return $this->getItems($menuItems, 0);*/
    }

    public static function getItems($menuItems, $fatherId)
    {
        $menuList = $menuItems->filter(function ($item) use ($fatherId) {
            return $item->fatherId == $fatherId;
        })->values();

        foreach ($menuList as $menuItem) {
            //if($menuItem->isItem == 0 && is_null($menuItem->subheader))
            if ($menuItem->isItem == 0)
                $menuItem->children = $this->getItems($menuItems, $menuItem->id);
        }

        return $menuList;
    }
}

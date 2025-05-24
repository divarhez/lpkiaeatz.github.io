<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Interfaces\MenuRepositoryInterface;

class MenuRepository implements MenuRepositoryInterface
{
    public function getAllMenus()
    {
        return Menu::with(['category', 'tenant'])->get();
    }

    public function getMenuById($id)
    {
        return Menu::findOrFail($id);
    }

    public function createMenu(array $data)
    {
        return Menu::create($data);
    }

    public function updateMenu($id, array $data)
    {
        $menu = $this->getMenuById($id);
        $menu->update($data);
        return $menu;
    }

    public function deleteMenu($id)
    {
        return Menu::destroy($id);
    }
}

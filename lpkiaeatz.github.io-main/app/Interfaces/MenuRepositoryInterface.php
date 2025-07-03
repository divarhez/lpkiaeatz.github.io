<?php

namespace App\Interfaces;

interface MenuRepositoryInterface
{
    public function getAllMenus();
    public function getMenuById($id);
    public function createMenu(array $data);
    public function updateMenu($id, array $data);
    public function deleteMenu($id);
}

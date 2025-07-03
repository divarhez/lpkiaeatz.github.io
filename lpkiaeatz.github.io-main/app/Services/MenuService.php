<?php

namespace App\Services;

use App\Interfaces\MenuRepositoryInterface;
use App\Exceptions\MenuNotFoundException;
use Illuminate\Support\Facades\Log;

class MenuService
{
    protected $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getAllMenus()
    {
        try {
            return $this->menuRepository->getAllMenus();
        } catch (\Exception $e) {
            Log::error('Error fetching menus: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createMenu(array $data)
    {
        try {
            return $this->menuRepository->createMenu($data);
        } catch (\Exception $e) {
            Log::error('Error creating menu: ' . $e->getMessage());
            throw $e;
        }
    }
}

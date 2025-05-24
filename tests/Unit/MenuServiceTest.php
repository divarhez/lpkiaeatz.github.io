<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MenuService;
use App\Repositories\MenuRepository;
use Mockery;

class MenuServiceTest extends TestCase
{
    protected $menuService;
    protected $menuRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->menuRepository = Mockery::mock(MenuRepository::class);
        $this->menuService = new MenuService($this->menuRepository);
    }

    public function test_can_get_all_menus()
    {
        $this->menuRepository
            ->shouldReceive('getAllMenus')
            ->once()
            ->andReturn([]);

        $result = $this->menuService->getAllMenus();
        $this->assertIsArray($result);
    }
}

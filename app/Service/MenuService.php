<?php

namespace App\Service;

use App\Exceptions\CustomException;
use App\Interface\MenuInterface;
use App\Models\SubMenu;
use App\Repository\MenuRepository;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MenuService
{
    protected $menu;

    public function __construct(MenuInterface $menu)
    {
        $this->menu = $menu;
    }
    public function createMainMenu(array $menu) : ?object
    {
        $menu['slug'] = self::slugGenerate($menu['title_uz']);
        if ($this->menu->getMenuBySlug($menu['slug'])) {
            throw new CustomException(409, "Menu already exists");
        }
        $menu['slug'] = self::slugGenerate($menu['title_uz']);

        return $this->menu->createMainMenu($menu);
    }

    public function getMainMenu() : array
    {
        return $this->menu->getMainMenu();
    }

    public function createSubMenu(array $menu) : ?object
    {
        $menu['slug'] = self::slugGenerate($menu['sub_title_uz']);
        if ($this->menu->getSubMenuBySlug($menu['slug'])) {
            throw new CustomException(409, "Menu already exists");
        }

        return $this->menu->createSubMenu($menu);
    }

    public function getSubMenu() : array
    {
        return $this->menu->getSubMenu();
    }

    public static function slugGenerate(string $title, string $separator = '-'): string
    {
        return Str::slug($title, $separator);
    }

    public function GetMenuIdBySlug(string $slug) : ?object
    {
        $query = SubMenu::query()
            ->where('slug', $slug)
            ->first();
        return $query;
    }
}

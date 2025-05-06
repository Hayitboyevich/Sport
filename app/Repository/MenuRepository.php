<?php

namespace App\Repository;

use App\Interface\MenuInterface;
use App\Models\Menu;
use App\Models\SubMenu;

class MenuRepository implements MenuInterface
{
    public function createMainMenu(array $data) : ?object
    {
        $query = Menu::create([
            "title_uz" => $data['title_uz'],
            "title_ru" => $data['title_ru'],
            "title_en" => $data['title_en'],
            "slug" => $data['slug']
        ]);
        return $query;
    }

    public function getMenuBySlug(string $slug) : ?object
    {
        return Menu::where('slug', $slug)->first();
    }

    public function getMainMenu() : array
    {
        $query = Menu::query()->get();
        return $query->toArray();
    }

    public function createSubMenu(array $data) : ?object
    {
        $query = SubMenu::create([
            'menu_id' => $data['menu_id'] ?? null,
            'sub_title_uz' => $data['sub_title_uz'] ?? null,
            'sub_title_ru' => $data['sub_title_ru'] ?? null,
            'sub_title_en' => $data['sub_title_en'] ?? null,
            'sub_type' => $data['sub_type'],
            'slug' => $data['slug']
        ]);

        if ($data['sub_type'] == 200){
            $query->update['parent_id'] = $data['parent_id'];
            SubMenu::query()->where('sub_menu_id', $data['parent_id'])->update(['sub_type' => 100]);
        }

        return $query;
    }

    public function getSubMenuBySlug(string $slug) : ?object
    {
        $query = SubMenu::query()
            ->where('slug', $slug)
            ->first();
        return $query;
    }

    public function getSubMenu() : array
    {
        $query = SubMenu::query()->get();
        return $query->toArray();
    }
}

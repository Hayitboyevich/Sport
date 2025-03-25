<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SubMenu;
use App\Service\MenuService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    use ResponseTrait;
    protected $menuService;
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function createMainMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_uz' => 'required|string',
            'title_ru' => 'required|string',
            'title_en' => 'required|string',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $create = $this->menuService->createMainMenu($request->all());
            return $this->responseSuccess($create);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode());
        }
    }

    public function MenuList(Request $request)
    {
        try {
            $list = $this->menuService->getMainMenu();
            return $this->responseSuccess($list);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode());
        }
    }

    public function createSubMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required',
            'sub_title_uz' => 'required|string',
            'sub_title_ru' => 'required|string',
            'sub_title_en' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $create = $this->menuService->createSubMenu($request->all());
            return $this->responseSuccess($create);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode());
        }
    }

    public function SubMenuList(Request $request)
    {
        try {
            $list = $this->menuService->getSubMenu();
            return $this->responseSuccess($list);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode());
        }
    }

    public function SubMenuType(Request $request, $id)
    {
        $id = intval($id);
        $id = htmlspecialchars($id);
        $request = SubMenu::query()
            ->where('sub_type', $id)
            ->get();

        return $this->responseSuccess($request);
    }

    public function MainMenu(Request $request)
    {
        $menus = Menu::all(); // Retrieve all main menus
        $result = [];

        foreach ($menus as $menu) {
            $submenus = SubMenu::where('menu_id', $menu->id)->get();

            $result[] = [
                "main_menu_id" => $menu->id,
                "main_menu_uz" => $menu->title_uz,
                "main_menu_ru" => $menu->title_ru,
                "main_menu_en" => $menu->title_en,
                "main_slug" => $menu->slug,
                "submenu" => $submenus->map(function ($submenu) {
                    return [
                        "submenu_id" => $submenu->id,
                        "submenu_title_uz" => $submenu->sub_title_uz,
                        "submenu_title_ru" => $submenu->sub_title_ru,
                        "submenu_title_en" => $submenu->sub_title_en,
                        "submenu_slug" => $submenu->slug,
                    ];
                })
            ];
        }

        return $this->responseSuccess($result);
    }



}

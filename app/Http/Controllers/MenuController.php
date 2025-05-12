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

            'title_uz' => 'required|max:100',
            'title_ru' => 'sometimes',
            'title_en' => 'sometimes',
            'slug' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $create = $this->menuService->createMainMenu($request->all());
            return $this->responseSuccess($create);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode(404, $e->getMessage());
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
            'menu_id' => 'sometimes',
            'sub_title_uz' => 'sometimes',
            'sub_title_ru' => 'sometimes',
            'sub_title_en' => 'sometimes',
            'sub_type' => 'required',
            'parent_id' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $create = $this->menuService->createSubMenu($request->all());
            return $this->responseSuccess($create);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode(404, $e->getMessage());
        }
    }

    public function editSubMenu($id, Request $request)
    {
        try {
          $subMenu = SubMenu::query()->findOrFail($id);
          $subMenu->update($request->all());
          return $this->responseSuccess($subMenu);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode($exception->getCode());
        }
    }

    public function editMainMenu($id, Request $request)
    {
        try {
            $menu = Menu::query()->findOrFail($id);

            $menu->update($request->all());
            return $this->responseSuccess($menu);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode($exception->getCode());
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
            ->when(isset($request->status), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            >when($id == 1, function ($q) {
                $q->whereIn('sub_type', [1, 200]);
            }, function ($q) use ($id) {
                $q->where('sub_type', $id);
            })
            ->orderBy('order')
            ->get();

        return $this->responseSuccess($request);
    }

    public function MainMenu(Request $request)
    {
        $menus = Menu::query()
            ->when(isset($request->status), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->orderBy('order')
            ->get();
        $result = [];

        foreach ($menus as $menu) {
            $submenus = SubMenu::query()
                ->when(isset($request->status), function ($q) use ($request) {
                    $q->where('status', $request->status);
                })
                ->where('menu_id', $menu->id)
                ->orderBy('order')->get();

            $result[] = [
                "main_menu_id" => $menu->id,
                "main_menu_uz" => $menu->title_uz,
                "main_menu_ru" => $menu->title_ru,
                "main_menu_en" => $menu->title_en,
                "main_slug" => $menu->slug,
                'order' => $menu->order,
                "status" => $menu->status,
                "submenu" => $submenus->map(function ($submenu) {
                        return [
                            "submenu_id" => $submenu->sub_menu_id,
                            "submenu_title_uz" => $submenu->sub_title_uz,
                            "submenu_title_ru" => $submenu->sub_title_ru,
                            "submenu_title_en" => $submenu->sub_title_en,
                            "order" => $submenu->order,
                            "status" => $submenu->status,
                            "submenu_slug" => $submenu->slug,
                            "submenu" => $submenu->submenus->map(function ($child){
                                return [
                                    "submenu_id" => $child->sub_menu_id,
                                    "submenu_title_uz" => $child->sub_title_uz,
                                    "submenu_title_ru" => $child->sub_title_ru,
                                    "submenu_title_en" => $child->sub_title_en,
                                    "order" => $child->order,
                                    "status" => $child->status,
                                    "submenu_slug" => $child->slug,
                                ];
                            })
                        ];

                })
            ];
        }

        return $this->responseSuccess($result);
    }



}

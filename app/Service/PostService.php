<?php

namespace App\Service;

use App\Exceptions\CustomException;
use App\Models\Member;
use App\Models\Page;
use App\Models\Post;
use App\Repository\PostRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
     protected $postRepository;
     protected $addonService;

     protected $menuService;
     public function __construct(PostRepository $postRepository, AddonService  $addonService, MenuService $menuService)
     {
         $this->postRepository = $postRepository;
         $this->addonService = $addonService;
         $this->menuService = $menuService;
     }

     public function createPost(array $data): ?object
     {

         $data['post_slug'] = self::slugGenerate($data['post_title']);
         if ($this->postRepository->getPostBySlug($data['post_slug'])) {
             throw new CustomException(409, "Post already exists");
         }
         $fileName = $this->addonService->FileUploadBase64($data['post_image'], $data['file_name']);
         if(!$fileName) {
             return null;
         }
         $data['post_image'] = $fileName;
         $post = $this->postRepository->createPost($data);
         return $post;
     }

     public function editPost(int $id, array $data): bool
     {

         $data['post_slug'] = self::slugGenerate($data['post_title']) . "-" . $id;

         if(!empty($data['post_old_image']))
         {
             if (Storage::exists('public/storage/sitefile/' . $data['post_old_image'])) {
                 Storage::delete('public/storage/sitefile/' . $data['post_old_image']);
             }

             $fileName = $this->addonService->FileUploadBase64($data['post_image'], $data['file_name']);
             if(!$fileName) {
                 return false;
             }
             $data['post_image'] = $fileName;
             $post = $this->postRepository->editPost($id, $data);
             return $post;
         }
         else
         {
             $post = $this->postRepository->editPost($id, $data);
             return $post;
         }

     }

     public function createMember(array $data): ?object
     {

         $fileName = $this->addonService->FileUploadBase64($data['member_photo'], $data['file_name']);
         if(!$fileName) {
             return null;
         }
         $data['member_photo'] = $fileName;
         $post = $this->postRepository->createMember($data);
         return $post;

     }

     public function editMember(int $id, array $data): bool
     {
         if(!empty($data['post_old_image']))
         {
             if (Storage::exists('public/storage/sitefile/' . $data['post_old_image'])) {
                 Storage::delete('public/storage/sitefile/' . $data['post_old_image']);
             }

             $fileName = $this->addonService->FileUploadBase64($data['member_photo'], $data['file_name']);
             if(!$fileName) {
                 return false;
             }
             $data['member_photo'] = $fileName;
             $post = $this->postRepository->editMember($id, $data);
             return $post;
         }
         else
         {
             $post = $this->postRepository->editMember($id, $data);
             return $post;
         }
     }

     public function PostList(int $page, int $perPage = 20) : array
     {
         return $this->postRepository->PostList($page, $perPage);
     }

     public function createPagePost(array $data): ?object
     {
         return $this->postRepository->createPagePost($data);
     }

    public static function slugGenerate(string $title, string $separator = '-'): string
    {
        return Str::slug($title, $separator);
    }

    public function GetMenuInfo(string $slug = null) : array
    {
        $menuInfo = $this->menuService->GetMenuIdBySlug($slug);
        if(!$menuInfo)
        {
            throw new CustomException(404);
        }

        $menuId = $menuInfo->sub_menu_id;
        $type = $menuInfo->sub_type;



        if($type == 1)
        {
            $queryPage = Page::query()
                ->join('sub_menus', 'pages.page_menu_id', '=', 'sub_menus.sub_menu_id')
                ->where('page_menu_id', $menuId)
                ->get();
            return $queryPage->toArray();
        }
        elseif($type == 2)
        {
            return [];
        }
        elseif ($type == 4)
        {
            $queryPage = Member::query()
                ->where('member_menu_id', $menuId)
                ->join("sub_menus", "members.member_menu_id", "=", "sub_menus.sub_menu_id")
                ->get();
            return $queryPage->toArray();
        }
        return [];
    }



}

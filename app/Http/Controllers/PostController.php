<?php

namespace App\Http\Controllers;

use App\Models\Kafedra;
use App\Models\Member;
use App\Models\Page;
use App\Models\Post;
use App\Models\SubMenu;
use App\Repository\PostRepository;
use App\Service\PostService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    use ResponseTrait;

    protected $postRepository;
    public function __construct(PostService $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function createPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_menu_id' => 'required',
            'post_title' => 'sometimes',
            'post_image' => 'sometimes',
            'post_desc' => 'sometimes',
            'post_content' => 'sometimes',
            'post_title_ru' => 'sometimes',
            'post_title_en' => 'sometimes',
            'post_desc_ru' => 'sometimes',
            'post_desc_en' => 'sometimes',
            'post_content_ru' => 'sometimes',
            'post_content_en' => 'sometimes',
            'post_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }
        try {
            $posts = $this->postRepository->createPost($request->all());
            return $this->responseSuccess($posts);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode(404, $e->getMessage());
        }
    }

    public function PostList(Request $request, $page)
    {

        try {
            $posts = $this->postRepository->PostList($page, 20);
            return $this->responseSuccess($posts);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode(500, $e->getMessage());
        }
    }

    public function deletePagePost($id)
    {
        try {
            $query = Page::query()->where('page_id', $id)->delete();
            if ($query) {
                return $this->responseSuccess();
            }
            else
            {
                return $this->responseErrorWithCode(400);
            }
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }
    }

    public function PostDelete($id)
    {
        try {
            $query = Post::query()
                ->where('post_id', $id)
                ->delete();
            if ($query) {
                return $this->responseSuccess();
            }
            else
            {
                return $this->responseErrorWithCode(400);
            }
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }
    }

    public function PostOne(Request $request, $id)
    {
        try {
            $query = Post::query()
                ->where('post_id', $id)
                ->first();
            return $this->responseSuccess($query);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }
    }

    public function getPost($id)
    {
        try {
            $query = Post::query()
                ->where('post_menu_id', $id)
                ->get();
            return $this->responseSuccess($query);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }
    }

    public function UploadImage(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d');
        $directory = "uploads/$today";


        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($directory, $fileName, 'public');

        return response()->json([
            'default' => asset("storage/$filePath")
        ]);
    }

    public function editPost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'post_menu_id' => 'required',
            'post_title' => 'sometimes',
            'post_image' => 'sometimes',
            'post_desc' => 'sometimes',
            'post_content' => 'sometimes',
            'post_title_ru' => 'sometimes',
            'post_title_en' => 'sometimes',
            'post_desc_ru' => 'sometimes',
            'post_desc_en' => 'sometimes',
            'post_content_ru' => 'sometimes',
            'post_content_en' => 'sometimes',
            'post_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $posts = $this->postRepository->editPost($id, $request->all());
            return $this->responseSuccess($posts);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }
    }

    public function createPagePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_menu_id' => 'required',
            'page_content' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }


        try {
            $posts = $this->postRepository->createPagePost($request->all());
            return $this->responseSuccess($posts);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }

    }

    public function editPagePost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'page_menu_id' => 'required',
            'page_content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $query = Page::query()
                ->where('page_id', $id)
                ->update([
                    'page_menu_id' => $request["page_menu_id"],
                    'page_content' => $request["page_content"],
                    'page_content_ru' => $request["page_content_ru"],
                    'page_content_en' => $request["page_content_en"]
                ]);

            return $this->responseSuccess($query);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }

    }

    public function pagePostList()
    {

        try {
            $query = Page::query()
                ->leftJoin("sub_menus", "pages.page_menu_id", "sub_menus.sub_menu_id")
                ->cursor();
            return $this->responseSuccess($query);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }
    }

    public function createMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_menu_id' => 'required',
            'member_photo' => 'required|string',
            'member_name' => 'sometimes',
            'member_deputy_name' => 'sometimes',
            'member_email' => 'required|string',
            'member_phone' => 'required|string',
            'member_address' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $posts = $this->postRepository->createMember($request->all());
            return $this->responseSuccess($posts);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }
    }

    public function editMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'member_menu_id' => 'required',
            'member_photo' => 'required|string',
            'member_name' => 'required|string',
            'member_deputy_name' => 'required|string',
            'member_email' => 'required|string',
            'member_phone' => 'required|string',
            'member_address' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $posts = $this->postRepository->editMember($id, $request->all());
            return $this->responseSuccess($posts);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }

    }

    public function memberList(Request $request, $id)
    {
         $query = Member::query()
             ->leftJoin("kafedras", "members.member_kafedra_id", "kafedras.kafedra_id")
             ->where('member_menu_id', $id)
             ->get();
         return $this->responseSuccess($query);
    }

    public function deleteMember(Request $request, $id)
    {
        try {
           Member::query()
                ->where('member_id', $id)
                ->delete();
            return $this->responseSuccess();
        } catch (\Exception $e) {
            return $this->responseErrorWithCode(500, $e->getMessage());
        }
    }

    public function createKafedra(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kafedra_menu_id' => 'required',
            'kafedra_name' => 'required|string',
            'kafedra_about' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        $query = Kafedra::query()
            ->create([
                'kafedra_menu_id' => $request->kafedra_menu_id,
                'kafedra_name' => $request['kafedra_name'],
                'kafedra_name_ru' => $request['kafedra_name_ru'],
                'kafedra_name_en' => $request['kafedra_name_en'],
                'kafedra_about' => $request['kafedra_about'],
                'kafedra_about_ru' => $request['kafedra_about_ru'],
                'kafedra_about_en' => $request['kafedra_about_en']
            ]);

        return $this->responseSuccess($query);

    }

    public function listKafedra()
    {
        $query = Kafedra::query()
            ->get();
        return $this->responseSuccess($query);
    }

    public function deleteKafedra(Request $request, $id)
    {
        $query = Kafedra::query()
            ->where('kafedra_id', $id)
            ->delete();
        return $this->responseSuccess();
    }

    public function editKafedra(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kafedra_menu_id' => 'required',
            'kafedra_name' => 'required|string',
            'kafedra_about' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
           Kafedra::query()
                ->where('kafedra_id', $id)
                ->update([
                    'kafedra_menu_id' => $request->kafedra_menu_id,
                    'kafedra_name' => $request['kafedra_name'],
                    'kafedra_name_ru' => $request['kafedra_name_ru'],
                    'kafedra_name_en' => $request['kafedra_name_en'],
                    'kafedra_about' => $request['kafedra_about'],
                    'kafedra_about_ru' => $request['kafedra_about_ru'],
                    'kafedra_about_en' => $request['kafedra_about_en']
                ]);
            return $this->responseSuccess();
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }

    }
    public function GetMenuInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $post = $this->postRepository->getMenuInfo($request->slug);
            return $this->responseSuccess($post);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }
    }

    public function getRelationPages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseErrorWithCode(404, $validator->errors()->toJson());
        }

        try {
            $query = SubMenu::query()
                ->where('slug', $request->slug)
                ->first();

            if (!$query) {
                return $this->responseErrorWithCode(404, 'SubMenu not found for the given slug.');
            }

            $data = SubMenu::query()
                ->where('menu_id', $query->menu_id)
                ->where('slug', '!=', $request->slug)
                ->get();
            return $this->responseSuccess($data);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode(), $e->getMessage());
        }
    }

}

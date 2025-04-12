<?php

namespace App\Repository;

use App\Interface\PostInterface;
use App\Models\Member;
use App\Models\Page;
use App\Models\Post;

class PostRepository implements PostInterface
{
    public function createPost(array $data) : ?object
    {
        $query = Post::create([
            "post_menu_id" => $data["post_menu_id"],
            "post_title" => $data["post_title"],
            "post_slug" => $data["post_slug"],
            "post_image" => $data["post_image"],
            "post_desc" => $data["post_desc"],
            "post_content" => $data["post_content"],
            "post_date" => $data["post_date"],
            "post_title_ru" => $data["post_title_ru"],
            "post_title_en" => $data["post_title_en"],
            "post_desc_ru" => $data["post_desc_ru"],
            "post_desc_en" => $data["post_desc_en"],
            "post_content_ru" => $data["post_content_ru"],
            "post_content_en" => $data["post_content_en"]
        ]);

        return $query;
    }

    public function getPostBySlug(string $slug) : ?object
    {
        $query = Post::query()
            ->where('post_slug', $slug)
            ->first();
        return $query;
    }

    public function postList(int $page, int $perPage = 20) : array
    {
        $posts = Post::query()
            ->orderBy('post_date', 'DESC')
            ->paginate($perPage, ['*'], 'page', $page); // Paginate to'g'ri ishlaydi

        return $posts->toArray();
    }

    public function editPost(int $id, array $data) : bool
    {
        $query = Post::query()
            ->where('post_id', $id)
            ->update([
            "post_menu_id" => $data["post_menu_id"],
            "post_title" => $data["post_title"],
            "post_slug" => $data["post_slug"],
            "post_image" => $data["post_image"],
            "post_desc" => $data["post_desc"],
            "post_content" => $data["post_content"],
            "post_date" => $data["post_date"],
            "post_title_ru" => $data["post_title_ru"],
            "post_title_en" => $data["post_title_en"],
            "post_desc_ru" => $data["post_desc_ru"],
            "post_desc_en" => $data["post_desc_en"],
            "post_content_ru" => $data["post_content_ru"],
            "post_content_en" => $data["post_content_en"]
        ]);

        return $query;
    }

    public function createPagePost(array $data) : ?object
    {
        if (Page::query()->where('page_menu_id', $data["page_menu_id"])->exists()) throw new \Exception('Sahifa kiritilgan');
        $query = Page::create([
            'page_menu_id' => $data["page_menu_id"],
            'page_content' => $data["page_content"],
            'page_content_ru' => $data["page_content_ru"],
            'page_content_en' => $data["page_content_en"]
        ]);

        return $query;
    }

    public function createMember(array $data) : ?object
    {
        $query = Member::create([
            'member_menu_id' => $data["member_menu_id"],
            'member_name' => $data["member_name"],
            'member_photo' => $data["member_photo"],
            'member_deputy_name' => $data["member_deputy_name"] ?? null,
            'member_email' => $data["member_email"],
            'member_phone' => $data["member_phone"],
            'member_address' => $data["member_address"],
            'member_bio' => $data["member_bio"] ?? null,
            'member_function' => $data["member_function"] ?? null,
            'member_name_ru' => $data["member_name_ru"] ?? null,
            'member_name_en' => $data["member_name_en"] ?? null,
            'member_deputy_name_ru' => $data["member_deputy_name_ru"] ?? null,
            'member_deputy_name_en' => $data["member_deputy_name_en"] ?? null,
            'member_bio_ru' => $data["member_bio_ru"] ?? null,
            'member_bio_en' => $data["member_bio_en"] ?? null,
            'member_function_ru' => $data["member_function_ru"] ?? null,
            'member_function_en' => $data["member_function_en"] ?? null,
            'member_kafedra_id' => $data["member_kafedra_id"]
        ]);

        return $query;
    }

    public function editMember(int $id, array $data) : bool
    {
        $query = Member::query()
            ->where('member_id', $id)
            ->update([
            'member_menu_id' => $data["member_menu_id"],
            'member_name' => $data["member_name"],
            'member_photo' => $data["member_photo"],
            'member_deputy_name' => $data["member_deputy_name"] ?? null,
            'member_email' => $data["member_email"],
            'member_phone' => $data["member_phone"],
            'member_address' => $data["member_address"],
            'member_bio' => $data["member_bio"] ?? null,
            'member_function' => $data["member_function"] ?? null,
            'member_name_ru' => $data["member_name_ru"],
            'member_name_en' => $data["member_name_en"],
            'member_deputy_name_ru' => $data["member_deputy_name_ru"] ?? null,
            'member_deputy_name_en' => $data["member_deputy_name_en"] ?? null,
            'member_bio_ru' => $data["member_bio_ru"] ?? null,
            'member_bio_en' => $data["member_bio_en"] ?? null,
            'member_function_ru' => $data["member_function_ru"] ?? null,
            'member_function_en' => $data["member_function_en"] ?? null,
            'member_kafedra_id' => $data["member_kafedra_id"]
        ]);

        return $query;
    }
}

<?php

namespace App\Interface;

interface PostInterface
{
    public function createPost(array $data) : ?object;

    public function getPostBySlug(string $slug) : ?object;
    public function postList(int $page, int $perPage = 20) : ?array;

    public function editPost(int $id, array $data) : bool;

    public function createPagePost(array $data) : ?object;

    public function createMember(array $data) : ?object;

    public function editMember(int $id, array $data) : bool;
}

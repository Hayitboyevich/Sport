<?php

namespace App\Interface;

interface MenuInterface
{
    public function createMainMenu(array $data): ?object;

    public function getMenuBySlug(string $slug) : ?object;

    public function getSubMenuBySlug(string $slug) : ?object;

    public function getMainMenu() : array;

    public function createSubMenu(array $data): ?object;

    public function getSubMenu() : array;
}

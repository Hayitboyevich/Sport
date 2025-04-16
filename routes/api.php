<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MurojaatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GaleryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/murojaat', [MurojaatController::class, 'createMurojaat']);
Route::get('/murojaat/{referenceNumber}', [MurojaatController::class, 'check']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('menu', [MenuController::class, 'MainMenu']);
Route::get('list-kafedra', [PostController::class, 'listKafedra']);
Route::post('post-info', [PostController::class, 'GetMenuInfo']);
Route::post('relation-pages', [PostController::class, 'getRelationPages']);
Route::get('post/{id}', [PostController::class, 'getPost']);
Route::get('post-one/{id}', [PostController::class, 'PostOne']);
Route::get('partners', [PartnerController::class, 'list']);
Route::get('partner/{id}', [PartnerController::class, 'getPartner']);
Route::get('links', [LinkController::class, 'list']);
Route::get('link/{id}', [LinkController::class, 'getOne']);
Route::get('statistics', [StatisticController::class, 'list']);
Route::get('statistic/{id}', [StatisticController::class, 'getOne']);
Route::get('services', [ServiceController::class, 'list']);
Route::get('service/{id}', [ServiceController::class, 'getOne']);
Route::get('galleries', [GaleryController::class, 'list']);
Route::get('gallery/{id}', [GaleryController::class, 'getOne']);
Route::get('member-list/{id}', [PostController::class, 'memberList']);


Route::middleware(['jwtauth'])->group(function () {
    Route::post('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('create-main-menu', [MenuController::class, 'createMainMenu']);
    Route::put('edit-main-menu/{id}', [MenuController::class, 'editMainMenu']);
    Route::post('order-menu', [PostController::class, 'orderMenu']);
    Route::get('main-menu-list', [MenuController::class, 'MenuList']);
    Route::post('create-sub-menu', [MenuController::class, 'createSubMenu']);
    Route::put('edit-sub-menu/{id}', [MenuController::class, 'editSubMenu']);
    Route::post('order-sub-menu', [PostController::class, 'orderSubMenu']);
    Route::get('sub-menu-list', [MenuController::class, 'SubMenuList']);
    Route::get('sub-menu-type/{id}', [MenuController::class, 'SubMenuType']);
    Route::post('create-post', [PostController::class, 'createPost']);
    Route::get('post-list/{id}', [PostController::class, 'PostList']);
    Route::delete('post/{id}', [PostController::class, 'PostDelete']);
    Route::post('upload-image', [PostController::class, 'UploadImage']);
    Route::put('edit-post/{id}', [PostController::class, 'editPost']);

    // Page Posts
    Route::post('create-page-post', [PostController::class, 'createPagePost']);
    Route::get('page-post-list', [PostController::class, 'pagePostList']);
    Route::put('edit-page-post/{id}', [PostController::class, 'editPagePost']);
    Route::delete('page/{id}', [PostController::class, 'deletePagePost']);

    // member
    Route::post('create-member', [PostController::class, 'createMember']);
    Route::delete('delete-member/{id}', [PostController::class, 'deleteMember']);
    Route::put('edit-member/{id}', [PostController::class, 'editMember']);

    // Kafedra

    Route::post('create-kafedra', [PostController::class, 'createKafedra']);
    Route::delete('delete-kafedra/{id}', [PostController::class, 'deleteKafedra']);
    Route::put('edit-kafedra/{id}', [PostController::class, 'editKafedra']);

    // Hamkorlar
    Route::delete('partner/delete/{id}', [PartnerController::class, 'delete']);
    Route::put('partner/edit/{id}', [PartnerController::class, 'edit']);
    Route::post('partner/create', [PartnerController::class, 'create']);

    // Foydali linklar

    Route::delete('link/delete/{id}', [LinkController::class, 'delete']);
    Route::put('link/edit/{id}', [LinkController::class, 'edit']);
    Route::post('link/create', [LinkController::class, 'create']);

    //Statistikalar

    Route::delete('statistic/delete/{id}', [StatisticController::class, 'delete']);
    Route::put('statistic/edit/{id}', [StatisticController::class, 'edit']);
    Route::post('statistic/create', [StatisticController::class, 'create']);
    Route::post('statistic/change-status', [StatisticController::class, 'changeStatus']);

    //Service
    Route::delete('service/delete/{id}', [ServiceController::class, 'delete']);
    Route::delete('delete-image/{id}', [ServiceController::class, 'imageDelete']);
    Route::put('service/edit/{id}', [ServiceController::class, 'edit']);
    Route::post('service/create', [ServiceController::class, 'create']);
    Route::post('service/change-status', [ServiceController::class, 'changeStatus']);


    //Gallery

    Route::delete('gallery/delete/{id}', [GaleryController::class, 'delete']);
    Route::put('gallery/edit/{id}', [GaleryController::class, 'edit']);
    Route::post('gallery/create', [GaleryController::class, 'create']);
    Route::post('gallery/change-status', [GaleryController::class, 'changeStatus']);

});

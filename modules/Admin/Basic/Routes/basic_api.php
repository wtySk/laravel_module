<?php
/**
 * Author: wtySk
 * Time: 13/11/2018  13:38
 */

use Illuminate\Support\Facades\Route;
use Modules\Admin\Basic\Controllers\AdminController;

Route::group([
    'prefix' => config('module.api_version_v1'),
    'middleware' => [
        'api',
    ],
    'namespace' => modules_namespace(__FILE__),
], function (Illuminate\Routing\Router $router) {
    //权限功能
    $router->group([
    ], function ($router) {
        /*----- 用户管理(子账户) -----*/
        $router->group([
        ], function ($router) {
            /*----- 用户列表 -----*/
            $router->group([
            ], function ($router) {
                $router->get('/users', [AdminController::class,'index']);
                $router->get('/users/{id}', [AdminController::class,'show']);
                $router->post('/users', [AdminController::class,'store']);
                $router->put('/users/{id}', [AdminController::class,'update']);
                $router->delete('/users/{id}', [AdminController::class,'destroy']);
                $router->delete('/users-batch-delete', [AdminController::class,'batchDelete']);
            });
        });
    });
});

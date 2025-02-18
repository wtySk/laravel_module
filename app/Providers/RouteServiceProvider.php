<?php
/**
 * Author: wtySk
 * Time: 2025/2/18  09:33
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The namespace to assume when generating URLs to your application's controllers.
     *
     * @var string
     */
    protected $namespace = 'App\\Http\\Controllers';


    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->mapModuleRoutesApi();  // 加载自定义模块路由
    }

    /**
     * 加载自定义模块的 API 路由
     * 优化版：减少手动的文件加载，直接通过集中管理的服务提供者进行加载
     */
    protected function mapModuleRoutesApi(): void
    {
        // 将模块路由的加载和服务注册分离
        $modules = ['Admin', 'Core'];

        foreach ($modules as $module) {
            $modulePath = base_path("modules/$module/*/Routes/*_api.php");

            // 使用 Laravel 集中的路由注册机制
            $this->loadModuleRoutes($modulePath);
        }
    }

    /**
     * 加载模块路由的公共方法
     */
    private function loadModuleRoutes($modulePath): void
    {
        foreach (glob($modulePath) as $route) {
            require $route;
        }
    }
}

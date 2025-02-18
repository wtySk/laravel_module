<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mapFunction();
    }

    public function mapFunction(): void
    {
        //设置日期提示为中文
        Carbon::setLocale('zh');
        //加载自定义函数库
        foreach (glob(base_path('modules/*/Libs/Function/*.php')) as $function) {
            require $function;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }



}

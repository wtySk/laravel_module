<?php
/**
 * Author: wtySk
 * Time: 2025/2/18  11:28
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('username',32)->comment('用户名')->unique()->index();
            $table->string('nickname',32)->comment('昵称');
            $table->string('password')->comment('密码');
            $table->string('mobile',32)->comment('手机号')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};

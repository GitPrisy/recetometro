<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname')->unique();
            $table->string('profile_image')->nullable();
            $table->string('email')->unique();
            $table->boolean('mailable')->default(false);
            $table->boolean('visible')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('rol_id')->default(3)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('recipes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');       
    }
}

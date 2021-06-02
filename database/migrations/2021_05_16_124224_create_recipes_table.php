<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable()->unique();
            $table->string('title');
            $table->string('description');
            $table->foreignId('mean_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('ingredients');
            $table->text('preparation');
            $table->boolean('visible')->default(true);
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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

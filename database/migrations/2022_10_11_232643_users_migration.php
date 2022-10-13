<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create("users", function(Blueprint $table){
            $table->increments("id");
            $table->string("name");
            $table->string("email");
            $table->string("password");
            $table->string("address");
            $table->string("complement")->nullable();
            $table->string("city");
            $table->dateTime("birthday");
            $table->unsignedInteger("status_id");
            $table->timestamps();

            $table->foreign("status_id")
                ->references("id")
                ->on("statuses")
                ->onUpdate("no action")
                ->onDelete("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists("users");
    }
};

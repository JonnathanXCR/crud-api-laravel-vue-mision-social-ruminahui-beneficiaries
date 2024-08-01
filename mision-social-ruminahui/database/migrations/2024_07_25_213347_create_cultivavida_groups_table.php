<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cultivavida_groups', function (Blueprint $table) {
            $table->id()->comment('Primary key: Unique identifier for the group');
            $table->unsignedBigInteger('tutor')->unique()->comment('Foreign key: User ID of the tutor');
            $table->text('description')->comment('Description of the group');
            $table->timestamps();
            $table->foreign('tutor')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade') 
                  ->comment('Foreign key constraint linking to the users table');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cultivavida_groups');
    }
};

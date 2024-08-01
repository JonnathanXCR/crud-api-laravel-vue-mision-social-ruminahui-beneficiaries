<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cultivavida_group_person', function (Blueprint $table) {
            // Clave foránea que referencia al ID del grupo en la tabla cultivavida_groups
            $table->unsignedBigInteger('cultivavida_group_id')->comment('Foreign key: ID of the group');
            
            // Clave foránea que referencia al DNI de la persona en la tabla persons
            $table->string('person_dni')->comment('External key: DNI of the person, this person attends to receive assistance from the Ruminahui Social Mission in the Cultiva Vida Service');
            
            // Timestamps para las fechas de creación y actualización
            $table->timestamps();

            // Definición de la clave primaria compuesta
            $table->primary(['cultivavida_group_id', 'person_dni'], 'group_person_primary');

            // Definición de la clave foránea que hace referencia a la tabla cultivavida_groups
            $table->foreign('cultivavida_group_id')
                  ->references('id')
                  ->on('cultivavida_groups')
                  ->onDelete('cascade')
                  ->comment('Foreign key constraint linking to the cultivavida_groups table');
            
            // Definición de la clave foránea que hace referencia a la tabla persons
            $table->foreign('person_dni')
                  ->references('dni')
                  ->on('persons')
                  ->onDelete('cascade')
                  ->comment('Foreign key constraint linking to the persons table');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cultivavida_group_person');
    }
};
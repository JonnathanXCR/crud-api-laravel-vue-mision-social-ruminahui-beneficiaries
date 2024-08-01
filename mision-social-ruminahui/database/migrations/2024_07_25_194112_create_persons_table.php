<?php
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
        Schema::create('persons', function (Blueprint $table) {
            $table->string('dni', 20)->primary()->comment('Primary key: Unique identification number for a person');
            $table->string('name', 50)->comment('First name of the person');
            $table->string('last_name', 50)->comment('Last name of the person');
            $table->string('email', 100)->unique()->comment('Unique email address of the person');
            $table->date('birthday')->comment('Date of birth of the person');
            $table->enum('gender', ['Masculino', 'Femenino', 'Otro'])->comment('Gender of the person');
            $table->string('address', 255)->comment('Address of the person');
            $table->string('phone', 15)->comment('Phone number of the person');
            $table->unsignedBigInteger('neighborhood_id')->nullable()->comment('Foreign key: Neighborhood ID where the person lives');
            $table->unsignedBigInteger('user_id')->nullable()->unique()->comment('Foreign key: Optional user ID associated with the person');
            $table->timestamps(); // Adds created_at and updated_at columns

            // Define foreign key constraint for neighborhood_id
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropForeign(['neighborhood_id']);
        });

        Schema::dropIfExists('persons');
    }
};

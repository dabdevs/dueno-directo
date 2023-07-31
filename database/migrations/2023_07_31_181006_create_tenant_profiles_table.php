<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('occupation');
            $table->decimal('income', 10, 2);
            $table->string('desired_location'); 
            $table->integer('number_of_occupants'); 
            $table->boolean('has_pets')->default(false); 
            $table->boolean('smoker')->default(false); 
            $table->enum('employment_status', ['employed', 'self-employed', 'unemployed', 'student']); 
            $table->text('additional_criteria')->nullable(); 
            $table->text('additional_notes')->nullable(); 
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
        Schema::dropIfExists('tenant_profiles');
    }
}

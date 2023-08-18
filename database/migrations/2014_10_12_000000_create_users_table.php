<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('given_name')->nullable();
            $table->string('family_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('type', ['owner', 'tenant', 'admin'])->nullable();

            // Profile details (for tenants)
            $table->string('occupation')->nullable();
            $table->decimal('income', 10, 2)->nullable();
            $table->string('desired_location')->nullable();
            $table->integer('number_of_occupants')->nullable();
            $table->boolean('has_pets')->default(false);
            $table->boolean('smoker')->default(false);
            $table->enum('employment_status', ['employed', 'self-employed', 'unemployed', 'student'])->nullable();
            $table->text('additional_note')->nullable(); 
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
        Schema::dropIfExists('users');
    }
}

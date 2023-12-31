<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('occupation')->nullable();
            $table->decimal('income', 10, 2)->nullable();
            $table->json('desired_locations')->nullable();
            $table->integer('number_of_occupants')->nullable();
            $table->boolean('has_pets')->default(false);
            $table->boolean('smoker')->default(false);
            $table->enum('employment_status', ['Employed', 'Self-Employed', 'Unemployed'])->nullable();
            $table->text('note')->nullable();
            $table->dateTime('verified_at')->nullable();
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
        Schema::dropIfExists('tenants');
    }
}

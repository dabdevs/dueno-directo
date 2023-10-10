<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->unique()->constrained();
            $table->string('occupation')->nullable();
            $table->decimal('min_income', 10, 2)->nullable();
            $table->decimal('max_income', 10, 2)->nullable();
            $table->integer('number_of_occupants')->nullable();
            $table->boolean('has_pets')->default(0);
            $table->boolean('smoker')->default(0);
            $table->boolean('only_verified')->default(0);
            $table->boolean('with_avatar')->default(0);
            $table->enum('employment_status', ['Employed', 'Self-Employed', 'Unemployed'])->nullable();
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
        Schema::dropIfExists('property_preferences');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('area');
            $table->string('location');
            $table->string('phone_number');
            $table->enum('property_type', ['House', 'Apartment', 'Condo']);
            $table->string('property_address');
            $table->text('property_description');
            $table->enum('lease_term', ['6 Months', '12 Months', '24 Months', '36 Months'])->nullable();
            $table->string('rent_payment_method')->nullable();
            $table->decimal('security_deposit', 10, 2)->nullable();
            $table->text('rental_agreement')->nullable();
            $table->text('preferred_tenant_profile')->nullable();
            $table->text('additional_note')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('users');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('users');
            $table->boolean('negotiable')->default(0);
            $table->enum('status', ['Unlisted', 'Published', 'Booked', 'Rented'])->default('Unlisted');
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
        Schema::dropIfExists('properties');
    }
}

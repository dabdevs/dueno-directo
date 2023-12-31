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
            $table->string('slug');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('area');
            $table->boolean('balcony')->default(0);
            $table->string('email')->nullable();
            $table->string('telephone');
            $table->string('address')->nullable();
            $table->enum('type', ['House', 'Apartment', 'Condo']);
            $table->boolean('patio')->default(0);
            $table->text('preferred_tenant_profile')->nullable();
            $table->foreignId('user_id')->onDelete('cascade');
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('users');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('users');
            $table->unsignedBigInteger('lawyer_id')->nullable();
            $table->foreign('lawyer_id')->references('id')->on('users');
            $table->foreignId('country_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->string('state')->nullable();
            $table->string('lease_term')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('security_deposit')->nullable();
            $table->string('neighborhood')->nullable();
            $table->enum('get_notified_by', ['Phone', 'Email'])->default('Email');
            $table->boolean('negotiable')->default(0);
            $table->enum('status', ['Unlisted', 'Published', 'Booked', 'Rented'])->default('Unlisted');
            $table->dateTime('date_published')->nullable();
            $table->dateTime('date_expires')->nullable();
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

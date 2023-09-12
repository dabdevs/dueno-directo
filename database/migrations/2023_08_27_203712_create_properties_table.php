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
            $table->string('title')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('area');
            $table->string('location');
            $table->string('phone_number');
            $table->string('property_type');
            $table->string('property_address');
            $table->text('property_description');
            $table->string('lease_term');
            $table->string('availability');
            $table->string('rent_payment_method');
            $table->decimal('security_deposit', 10, 2);
            $table->text('rental_agreement')->nullable();
            $table->text('preferred_tenant_profile')->nullable();
            $table->text('additional_note')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->boolean('active')->default(1);
            $table->boolean('negotiable')->default(0);
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

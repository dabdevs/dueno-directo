<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone_number');
            $table->string('property_address');
            $table->enum('property_type', ['apartment', 'house', 'condo']);
            $table->text('property_description')->nullable();
            $table->decimal('rental_price', 10, 2);
            $table->enum('lease_term', ['monthly', 'quarterly', 'yearly']);
            $table->date('availability')->nullable();
            $table->enum('rent_payment_method', ['bank_transfer', 'check', 'cash']);
            $table->decimal('security_deposit', 10, 2);
            $table->text('rental_agreement')->nullable();
            $table->text('preferred_tenant_profile')->nullable();
            $table->text('additional_note')->nullable();
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
        Schema::dropIfExists('listings');
    }
}

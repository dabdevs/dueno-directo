<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->onDelete('cascade');
            $table->foreignId('property_id')->onDelete('cascade');
            $table->text('note');
            $table->boolean('viewed')->default(0);
            $table->enum('status', ['Approved', 'Rejected', 'Pending', 'Archived'])->default('Pending');
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->boolean('archived_by_applicant')->default(0); // Indicates if the application is archived by the applicant
            $table->boolean('archived_by_propertys_owner')->default(0); // Indicates if the application is archived by the property's owner
            $table->integer('archived_by_admin')->nullable(); // ID of the admin user that archived the application
            $table->dateTime('archived_at')->nullable();
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
        Schema::dropIfExists('property_applications');
    }
}

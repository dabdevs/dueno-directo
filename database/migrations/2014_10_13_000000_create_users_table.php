<?php

use App\Models\User;
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
            $table->enum('role', [User::ROLE_OWNER,User::ROLE_RENTER, User::ROLE_TENANT, User::ROLE_ADMIN, User::ROLE_LAWYER, User::ROLE_AGENT]);
            $table->string('telephone')->nullable();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->foreignId('city_id')->nullable()->constrained();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('appartment')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_verified')->default(0);
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

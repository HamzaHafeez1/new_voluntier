<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('org_name', 255)->nullable();
            $table->integer('org_type')->nullable();
            $table->integer('school_type')->nullable();
            $table->string('ein', 100)->nullable();
            $table->string('nonprofit_org_type', 200)->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('user_role', 45)->nullable();           
            $table->string('user_name', 255);
            $table->string('email', 255)->nullable();            
            $table->string('password', 255)->nullable();
            $table->string('birth_date', 45)->nullable();
            $table->string('gender', 45)->nullable();
            $table->integer('zipcode')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('lat', 255)->nullable();
            $table->string('lng', 255)->nullable();
            $table->string('contact_number', 255)->nullable(); 
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
        Schema::dropIfExists('user_temp');
    }
}

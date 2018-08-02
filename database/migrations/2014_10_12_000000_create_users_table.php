<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Role;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            
            //campos cashier
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->string('trial_ends_at')->nullable();
            
            //FK
            $table->unsignedInteger('role_id')->default(Role::STUDENT);
            $table->foreign('role_id')->references('id')->on('roles');
            
            $table->rememberToken();
            $table->timestamps();
        });
        
         Schema::create('suscriptions', function (Blueprint $table) {
            $table->increments('id')->unsigned();       
             $table->string('name');
             $table->integer('stripe_id')->unsigned();
             $table->string('stripe_plan');
             $table->integer('quantity');
             $table->timestamp('trial_ends_at')->nullable();
             $table->timestamp('ends_at')->nullable();
             
             //FK
             $table->integer('user_id')->unsigned();  
             $table->foreign('user_id')->references('id')->on('users');
             
             $table->timestamps();
             
         });
        Schema::create('user_social_accounts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
             $table->string('provider');
             $table->string('provider_uid');
             //FK
             $table->integer('user_id')->unsigned();
             $table->foreign('user_id')->references('id')->on('users');
             

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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('suscriptions');
        Schema::dropIfExists('user_social_accounts');
    }
}

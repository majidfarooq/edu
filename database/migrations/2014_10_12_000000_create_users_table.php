<?php

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
    public $tableName = 'users';
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->enum('type',['student','university'])->nullable();
            $table->string('phone',255)->nullable();
            $table->string('fax',255)->nullable();
            $table->string('gender',255)->nullable();
            $table->string('image',255)->nullable();
            $table->string('dob',255)->nullable();
            $table->string('email',255)->unique()->nullable();
            $table->string('uni_email',255)->unique()->nullable();
            $table->string('city',255)->default('')->nullable();
            $table->string('state',255)->default('')->nullable();
            $table->string('zipcode',255)->default('')->nullable();
            $table->string('country',255)->default('')->nullable();
            $table->string('ethnicity',255)->default('')->nullable();
            $table->text('other_info')->default(null)->nullable();
            $table->text('fullname')->default(null)->nullable();
            $table->text('address1')->default(null)->nullable();
            $table->text('address2')->default(null)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255)->nullable();
            $table->rememberToken();

            $table->integer('singup_steps')->nullable();
            $table->tinyInteger('hbcu')->default(0)->nullable();
            $table->tinyInteger('isFeatured')->default(0)->nullable();
            $table->tinyInteger('isActive')->default(0)->nullable();

            $table->text('latitude')->default(null)->nullable();
            $table->text('longitude')->default(null)->nullable();

            $table->softDeletes();
            $table->nullableTimestamps();
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

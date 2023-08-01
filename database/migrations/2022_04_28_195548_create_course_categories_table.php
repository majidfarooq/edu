<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $tableName = 'course_categories';
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('user_id')->default(null)->nullable();
            $table->index(["user_id"], 'course_categories_user_id_foreign_idx');

            $table->string('title',255)->default('')->nullable();
            $table->string('slug',255)->default('')->nullable();
            $table->tinyInteger('isActive')->default(null)->nullable();

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
        Schema::dropIfExists('course_categories');
    }
}

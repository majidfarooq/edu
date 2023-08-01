<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $tableName = 'courses';
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('user_id')->default(null)->nullable();
            $table->index(["user_id"], 'courses_user_id_foreign_idx');

            $table->unsignedInteger('category_id')->default(null)->nullable();
            $table->index(["category_id"], 'courses_category_id_foreign_idx');

            $table->string('title',255)->default('')->nullable();
            $table->string('slug',255)->default('')->nullable();
            $table->string('degree_program',255)->default('')->nullable();
            $table->dateTime('publish_date')->default(null)->nullable();
            $table->dateTime('due_date')->default(null)->nullable();
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
        Schema::dropIfExists('courses');
    }
}

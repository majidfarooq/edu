<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentViewedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $tableName = 'recent_vieweds';
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('uni_id')->default(null)->nullable();
            $table->index(["uni_id"], 'student_factors_uni_id_foreign_idx');

            $table->unsignedInteger('student_id')->default(null)->nullable();
            $table->index(["student_id"], 'student_factors_student_id_foreign_idx');

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
        Schema::dropIfExists('recent_vieweds');
    }
}

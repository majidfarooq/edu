<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $tableName = 'applications';
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('user_id')->default(null)->nullable();
            $table->index(["user_id"], 'applications_user_id_foreign_idx');

            $table->unsignedInteger('uni_id')->default(null)->nullable();
            $table->index(["uni_id"], 'applications_uni_id_foreign_idx');

            $table->unsignedInteger('program_type')->default(null)->nullable();
            $table->index(["program_type"], 'applications_program_type_foreign_idx');

            $table->unsignedInteger('course_id')->default(null)->nullable();
            $table->index(["course_id"], 'applications_course_id_foreign_idx');

            $table->string('apply_via',255)->default('')->nullable();
            $table->string('season',255)->default('')->nullable();
            $table->enum('status',['mark_pending','approve_shortlist','rejected','offer_extend'])->default(null)->nullable();

            $table->tinyInteger('isOffered')->default(null)->nullable();
            $table->tinyInteger('isPopup')->default(null)->nullable();
            $table->tinyInteger('notInterested')->default(null)->nullable();
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
        Schema::dropIfExists('applications');
    }
}

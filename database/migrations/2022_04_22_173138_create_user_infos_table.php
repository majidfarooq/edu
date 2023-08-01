<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $tableName = 'user_infos';
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('user_id')->default(null)->nullable();
            $table->index(["user_id"], 'user_infos_user_id_foreign_idx');

            $table->string('student_type',255)->default('')->nullable();
            $table->string('education_level',255)->default('')->nullable();
            $table->string('institution',255)->default('')->nullable();
            $table->string('interest',255)->default('')->nullable();

            $table->dateTime('deadline_start')->default(null)->nullable();
            $table->dateTime('deadline_end')->default(null)->nullable();

            $table->decimal('annual_in_state')->default(null)->nullable();
            $table->decimal('annual_out_state')->default(null)->nullable();

            $table->decimal('manda_in_state')->default(null)->nullable();
            $table->decimal('manda_out_state')->default(null)->nullable();

            $table->decimal('room_in_state')->default(null)->nullable();
            $table->decimal('room_out_state')->default(null)->nullable();

            $table->decimal('dis_in_state')->default(null)->nullable();
            $table->decimal('dis_out_state')->default(null)->nullable();

            $table->decimal('tyearly_in_state')->default(null)->nullable();
            $table->decimal('tyearly_out_state')->default(null)->nullable();

            $table->decimal('pann_in_state')->default(null)->nullable();
            $table->decimal('pann_out_state')->default(null)->nullable();

            $table->decimal('pdis_in_state')->default(null)->nullable();
            $table->decimal('pdis_out_state')->default(null)->nullable();

            $table->decimal('pcredit_in_state')->default(null)->nullable();
            $table->decimal('pcredit_out_state')->default(null)->nullable();

            $table->text('scholarship_info')->default(null)->nullable();
            $table->text('other_info')->default(null)->nullable();

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
        Schema::dropIfExists('user_infos');
    }
}

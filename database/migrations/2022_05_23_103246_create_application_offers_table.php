<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $tableName = 'application_offers';
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('application_id')->default(null)->nullable();
            $table->index(["application_id"], 'application_offers_application_id_foreign_idx');

            $table->string('title',255)->default('')->nullable();
            $table->string('attachment',255)->default('')->nullable();
            $table->text('desc')->default(null)->nullable();

            $table->tinyInteger('isAccepted')->default(0)->nullable();

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
        Schema::dropIfExists('application_offers');
    }
}

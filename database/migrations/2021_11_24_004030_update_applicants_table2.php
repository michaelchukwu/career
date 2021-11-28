<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicantsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('marital')->nullable();
            $table->string('state_of_orign')->nullable();
            $table->string('job_city')->nullable();
            $table->integer('score')->nullable();
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->boolean('has_marital')->default(false);
            $table->boolean('has_state_of_orign')->default(false);
            $table->boolean('has_job_city')->default(false);
            $table->boolean('has_score')->default(false);
            $table->boolean('marital_r')->default(false);
            $table->boolean('state_of_orign_r')->default(false);
            $table->boolean('job_city_r')->default(false);
            $table->boolean('score_r')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            Schema::table('applicants', function (Blueprint $table) {
                $table->dropColumn('marital');
                $table->dropColumn('state_of_orign');
                $table->dropColumn('job_city');
                $table->dropColumn('score');
            });
            Schema::table('jobs', function (Blueprint $table) {
                $table->dropColumn('has_marital');
                $table->dropColumn('has_state_of_orign');
                $table->dropColumn('has_job_city');
                $table->dropColumn('has_score');
                $table->dropColumn('marital_r');
                $table->dropColumn('state_of_orign_r');
                $table->dropColumn('job_city_r');
                $table->dropColumn('score_r');
            });
        });
    }
}

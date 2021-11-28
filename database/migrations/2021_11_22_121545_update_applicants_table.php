<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('age')->nullable()->after('email');
            $table->date('dob')->nullable()->after('age');
            $table->string('gender')->nullable()->after('dob');
            $table->string('exp_post')->nullable()->after('gender');
            $table->string('experience')->nullable()->after('exp_post');
            $table->string('first_degree')->nullable()->after('experience');
            $table->string('first_course')->nullable()->after('first_degree');
            $table->string('first_grade')->nullable()->after('first_name');
            $table->string('second_degree')->nullable()->after('first_course');
            $table->string('second_course')->nullable()->after('second_degree');
            $table->string('third_degree')->nullable()->after('second_course');
            $table->string('third_course')->nullable()->after('third_degree');
            $table->string('professional')->nullable()->after('third_course');
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->boolean('has_age')->default(false);
            $table->boolean('has_dob')->default(false);
            $table->boolean('has_gender')->default(false);
            $table->boolean('has_first_course')->default(false);
            $table->boolean('has_exp_post')->default(false);
            $table->boolean('has_experience')->default(false);
            $table->boolean('has_first_degree')->default(false);
            $table->boolean('has_first_grade')->default(false);
            $table->boolean('has_second_degree')->default(false);
            $table->boolean('has_second_course')->default(false);
            $table->boolean('has_third_degree')->default(false);
            $table->boolean('has_third_course')->default(false);
            $table->boolean('has_professional')->default(false);
            $table->boolean('age_r')->default(false);
            $table->boolean('dob_r')->default(false);
            $table->boolean('gender_r')->default(false);
            $table->boolean('first_course_r')->default(false);
            $table->boolean('exp_post_r')->default(false);
            $table->boolean('experience_r')->default(false);
            $table->boolean('first_degree_r')->default(false);
            $table->boolean('first_grade_r')->default(false);
            $table->boolean('second_degree_r')->default(false);
            $table->boolean('second_course_r')->default(false);
            $table->boolean('third_degree_r')->default(false);
            $table->boolean('third_course_r')->default(false);
            $table->boolean('professional_r')->default(false);
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
            //
            $table->dropColumn('age');
            $table->dropColumn('dob');
            $table->dropColumn('gender');
            $table->dropColumn('exp_post');
            $table->dropColumn('experience');
            $table->dropColumn('first_degree');
            $table->dropColumn('first_course');
            $table->dropColumn('first_grade');
            $table->dropColumn('second_degree');
            $table->dropColumn('second_course');
            $table->dropColumn('third_degree');
            $table->dropColumn('third_course');
            $table->dropColumn('professional');
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('has_age');
            $table->dropColumn('has_dob');
            $table->dropColumn('has_gender');
            $table->dropColumn('has_first_course');
            $table->dropColumn('has_exp_post');
            $table->dropColumn('has_experience');
            $table->dropColumn('has_first_degree');
            $table->dropColumn('has_first_grade');
            $table->dropColumn('has_second_degree');
            $table->dropColumn('has_second_course');
            $table->dropColumn('has_third_degree');
            $table->dropColumn('has_third_course');
            $table->dropColumn('has_professional');
            $table->dropColumn('age_r');
            $table->dropColumn('dob_r');
            $table->dropColumn('gender_r');
            $table->dropColumn('first_course_r');
            $table->dropColumn('exp_post_r');
            $table->dropColumn('experience_r');
            $table->dropColumn('first_degree_r');
            $table->dropColumn('first_grade_r');
            $table->dropColumn('second_degree_r');
            $table->dropColumn('second_course_r');
            $table->dropColumn('third_degree_r');
            $table->dropColumn('third_course_r');
            $table->dropColumn('professional_r');
        });
    }
}

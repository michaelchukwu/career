<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamps();
        });
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('job_type_id')->constrained('job_types');
            $table->text('description')->nullable();
            $table->decimal('salary', 8, 2)->nullable();
            $table->string('salary_duration')->default('Year');
            $table->string('location')->nullable();
            $table->string('slug')->unique();
            $table->boolean('is_live')->default(false);
            $table->boolean('can_expire')->default(false);
            $table->dateTime('goes_live')->nullable();
            $table->dateTime('expires')->nullable();
            $table->boolean('has_phone')->default(false);
            $table->boolean('has_first_name')->default(false);
            $table->boolean('has_last_name')->default(false);
            $table->boolean('has_linkedin')->default(false);
            $table->boolean('has_twitter')->default(false);
            $table->boolean('has_facebook')->default(false);
            $table->boolean('has_website')->default(false);
            $table->boolean('has_cv')->default(false);
            $table->boolean('has_cover_letter')->default(false);
            $table->boolean('has_image')->default(false);
            $table->boolean('has_state')->default(false);
            $table->boolean('has_city')->default(false);
            $table->boolean('has_street')->default(false);
            $table->boolean('phone_r')->default(false);
            $table->boolean('first_name_r')->default(false);
            $table->boolean('last_name_r')->default(false);
            $table->boolean('linkedin_r')->default(false);
            $table->boolean('twitter_r')->default(false);
            $table->boolean('facebook_r')->default(false);
            $table->boolean('website_r')->default(false);
            $table->boolean('cv_r')->default(false);
            $table->boolean('cover_letter_r')->default(false);
            $table->boolean('image_r')->default(false);
            $table->boolean('state_r')->default(false);
            $table->boolean('city_r')->default(false);
            $table->boolean('street_r')->default(false);
            $table->timestamps();
        });
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('website')->nullable();
            $table->string('cv')->nullable();
            $table->string('cover_letter')->nullable();
            $table->string('image')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->timestamps();
        });
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants');
            $table->foreignId('job_id')->constrained('jobs');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_types');
        Schema::dropIfExists('applicants');
        Schema::dropIfExists('applications');
    }
}

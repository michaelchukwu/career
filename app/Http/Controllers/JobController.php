<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = DB::table('jobs')
        ->join('job_types', 'jobs.job_type_id', '=', 'job_types.id')
        ->orderBy('jobs.id','DESC')
        ->select(
            'jobs.id as jobs_id',
            'job_types.id as job_types_id',
            'jobs.title as jobs_title',
            'job_types.title as job_types_title',
            'jobs.created_at',
            'jobs.is_live')
        ->paginate(20);
        return Inertia::render('Job/Index',['jobs'=>$jobs]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $job_types = DB::table('job_types')->get();
        return Inertia::render('Job/Create',['job_types'=> $job_types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'title'=>'required',
        //     'type'=>'required',
        //     'description'=>'required',
        //     'location'=>'required',
        //     'slug'=>'required'
        // ]);

        $input = $request->all();

        // $job = Job::create($input);
        $job = DB::table('jobs')->insert([
            'title'=>$request->title,
            'job_type_id'=>$request->type,
            'description'=>$request->description,
            'location'=>$request->location,
            'slug'=>$request->title.now(),
            'is_live'=>$request->is_live,
            'salary'=>$request->salary,
            'salary_duration'=>$request->salary_duration,
            'can_expire'=>$request->can_expire,
            'goes_live'=>$request->goes_live,
            'expires'=>$request->expires,
            'has_phone'=>$request->has_phone,
            'has_first_name'=>true,
            // 'has_first_name'=>$request->has_first_name,
            'has_last_name'=>true,
            'has_linkedin'=>$request->has_linkedin,
            'has_twitter'=>$request->has_twitter,
            'has_facebook'=>$request->has_facebook,
            'has_website'=>$request->has_website,
            'has_cv'=>$request->has_cv,
            'has_cover_letter'=>$request->has_cover_letter,
            'has_image'=>$request->has_image,
            'has_state'=>$request->has_state,
            'has_city'=>$request->has_city,
            'has_street'=>$request->has_street,
            'phone_r'=>$request->phone_r,
            'first_name_r'=>$request->first_name_r,
            'last_name_r'=>$request->last_name_r,
            'linkedin_r'=>$request->linkedin_r,
            'twitter_r'=>$request->twitter_r,
            'facebook_r'=>$request->facebook_r,
            'website_r'=>$request->website_r,
            'cv_r'=>$request->cv_r,
            'cover_letter_r'=>$request->cover_letter_r,
            'image_r'=>$request->image_r,
            'state_r'=>$request->state_r,
            'city_r'=>$request->city_r,
            'street_r'=>$request->street_r,
            'has_age'=>$request->has_age,
            'has_dob'=>$request->has_dob,
            'has_gender'=>$request->has_gender,
            'has_first_course'=>$request->has_first_course,
            'has_exp_post'=>$request->has_exp_post,
            'has_experience'=>$request->has_experience,
            'has_first_degree'=>$request->has_first_degree,
            'has_second_degree'=>$request->has_second_degree,
            'has_second_course'=>$request->has_second_course,
            'has_third_degree'=>$request->has_third_degree,
            'has_third_course'=>$request->has_third_course,
            'has_professional'=>$request->has_professional,
            'age_r'=>$request->age_r,
            'dob_r'=>$request->dob_r,
            'gender_r'=>$request->gender_r,
            'first_course_r'=>$request->first_course_r,
            'exp_post_r'=>$request->exp_post_r,
            'experience_r'=>$request->experience_r,
            'first_degree_r'=>$request->first_degree_r,
            'second_degree_r'=>$request->second_degree_r,
            'second_course_r'=>$request->second_course_r,
            'third_degree_r'=>$request->third_degree_r,
            'third_course_r'=>$request->third_course_r,
            'professional_r'=>$request->professional_r,
            'created_at'=>now()
        ]);

        return redirect()->route('jobs.index')
                        ->with('success','Jobs created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $job_type = JobType::find($job->job_type_id);
        return Inertia::render('Job/View',['job'=>$job, 'job_type'=>$job_type]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {

        $job_types = JobType::all();
        $job_type = JobType::find($job->job_type_id);

        return Inertia::render('Job/Edit',['job'=>$job,'job_types'=>$job_types,'job_type'=>$job_type]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email,'.$id,
        //     'password' => 'same:confirm-password',
        //     'roles' => 'required'
        // ]);
        $input = $request->all();
        // $job->update($input);
        $job->title=$request->title;
        $job->job_type_id=$request->type;
        $job->description=$request->description;
        $job->location=$request->location;
        $job->slug=$request->slug;
        $job->is_live=$request->is_live;
        $job->salary=$request->salary;
        $job->salary_duration=$request->salary_duration;
        $job->can_expire=$request->can_expire;
        $job->goes_live=$request->goes_live;
        $job->expires=$request->expires;
        $job->has_phone=$request->has_phone;
        $job->has_first_name=$request->has_first_name;
        $job->has_last_name=$request->has_last_name;
        $job->has_linkedin=$request->has_linkedin;
        $job->has_twitter=$request->has_twitter;
        $job->has_facebook=$request->has_facebook;
        $job->has_website=$request->has_website;
        $job->has_cv=$request->has_cv;
        $job->has_cover_letter=$request->has_cover_letter;
        $job->has_image=$request->has_image;
        $job->has_state=$request->has_state;
        $job->has_city=$request->has_city;
        $job->has_street=$request->has_street;
        $job->phone_r=$request->phone_r;
        $job->first_name_r=$request->first_name_r;
        $job->last_name_r=$request->last_name_r;
        $job->linkedin_r=$request->linkedin_r;
        $job->twitter_r=$request->twitter_r;
        $job->facebook_r=$request->facebook_r;
        $job->website_r=$request->website_r;
        $job->cv_r=$request->cv_r;
        $job->cover_letter_r=$request->cover_letter_r;
        $job->image_r=$request->image_r;
        $job->state_r=$request->state_r;
        $job->city_r=$request->city_r;
        $job->street_r=$request->street_r;
        $job->has_age=$request->has_age;
        $job->has_dob=$request->has_dob;
        $job->has_gender=$request->has_gender;
        $job->has_first_course=$request->has_first_course;
        $job->has_exp_post=$request->has_exp_post;
        $job->has_experience=$request->has_experience;
        $job->has_first_degree=$request->has_first_degree;
        $job->has_second_degree=$request->has_second_degree;
        $job->has_second_course=$request->has_second_course;
        $job->has_third_degree=$request->has_third_degree;
        $job->has_third_course=$request->has_third_course;
        $job->has_professional=$request->has_professional;
        $job->age_r=$request->age_r;
        $job->dob_r=$request->dob_r;
        $job->gender_r=$request->gender_r;
        $job->first_course_r=$request->first_course_r;
        $job->exp_post_r=$request->exp_post_r;
        $job->experience_r=$request->experience_r;
        $job->first_degree_r=$request->first_degree_r;
        $job->second_degree_r=$request->second_degree_r;
        $job->second_course_r=$request->second_course_r;
        $job->third_degree_r=$request->third_degree_r;
        $job->third_course_r=$request->third_course_r;
        $job->professional_r=$request->professional_r;
        $job->updated_at=now();
        $job->save();
        return redirect()->route('jobs.index')
                        ->with('success','Job updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
       $job->delete();
        return back()->with('success','User deleted successfully');
    }
    public function publish($id){
        $job = Job::find($id);
        $job->is_live = true;
        $job->save();
        return back()->with('success', 'Published');
    }
    public function unPublish($id){
        $job = Job::find($id);
        $job->is_live = false;
        $job->save();
        return back()->with('success', 'Unpublished');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'jobs.created_at')
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
        $this->validate($request, [
            'title'=>'required',
            'type'=>'required',
            'description'=>'required',
            'location'=>'required',
            'slug'=>'required'
        ]);

        $input = $request->all();

        // $job = Job::create($input);
        $job = DB::table('jobs')->insert([
            'title'=>$request->title,
            'job_type_id'=>$request->type,
            'description'=>$request->description,
            'location'=>$request->location,
            'slug'=>$request->slug,
            'is_live'=>$request->is_live,
            'salary'=>$request->salary,
            'salary_duration'=>$request->salary_duration,
            'can_expire'=>$request->can_expire,
            'goes_live'=>$request->goes_live,
            'expires'=>$request->expires,
            'has_phone'=>$request->has_phone,
            'has_first_name'=>$request->has_first_name,
            'has_last_name'=>$request->has_last_name,
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
    }
}

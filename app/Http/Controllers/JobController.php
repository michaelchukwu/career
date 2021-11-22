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

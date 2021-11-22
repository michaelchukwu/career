<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationsExport;
use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = DB::table('applications')
        ->join('applicants', 'applications.applicant_id', '=', 'applicants.id')
        ->join('jobs', 'applications.job_id', '=', 'jobs.id')
        ->join('job_types', 'jobs.job_type_id', '=', 'job_types.id')
        ->orderBy('applications.id','DESC')
        ->select(
        "applications.status",
        "applications.created_at",
        "applications.updated_at",
        "applicants.email",
        "applicants.phone",
        "applicants.first_name",
        "applicants.last_name",
        "applicants.linkedin",
        "applicants.twitter",
        "applicants.facebook",
        "applicants.website",
        "applicants.cv",
        "applicants.cover_letter",
        "applicants.image",
        "applicants.state",
        "applicants.city",
        "applicants.street",
        "applications.id",
        "jobs.title as job_title",
        "job_types.title as job_type",
        "jobs.location",
        )
        ->paginate(10);
        // dd($applications);
        return Inertia::render('Applications/Index',['applications'=>$applications]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
    public function export()
    {
        return Excel::download(new ApplicationsExport, 'applications-'.now().'.xlsx');
        // return back();

    }
}

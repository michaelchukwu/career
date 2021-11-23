<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicationsExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            '#',
            "Position",
            "First Name",
            "Last Name",
            "Phone Number",
            "Email",
            "Application Status",
            "Linkedin",
            "Twitter",
            "Facebook",
            "Applicant's Website",
            "CV",
            "Cover Letter",
            "State",
            "City",
            "Street",
            "Type",
            "Location",
            "Date",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('applications')
        ->join('applicants', 'applications.applicant_id', '=', 'applicants.id')
        ->join('jobs', 'applications.job_id', '=', 'jobs.id')
        ->join('job_types', 'jobs.job_type_id', '=', 'job_types.id')
        ->orderBy('applications.id','DESC')
        ->select(
        "applications.id",
        "jobs.title as job_title",
        "applicants.first_name",
        "applicants.last_name",
        "applicants.phone",
        "applicants.email",
        "applications.status",
        "applicants.linkedin",
        "applicants.twitter",
        "applicants.facebook",
        "applicants.website",
        "applicants.cv",
        "applicants.cover_letter",
        "applicants.state",
        "applicants.city",
        "applicants.street",
        "job_types.title as job_type",
        "jobs.location",
        "applications.created_at",
        )
        ->get();
    }
}

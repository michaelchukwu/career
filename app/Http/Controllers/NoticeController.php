<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notices = Notice::orderBy('id','DESC')->paginate(5);
        return Inertia::render('Notices/Index',['notices'=>$notices, 'i'=>($request->input('page', 1) - 1) * 5]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Notices/Create');
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
            'title' => 'nullable',
            'description' => 'nullable',
            'position' => 'nullable',
            'color' => 'nullable'
        ]);

        $input = $request->all();

        $user = Notice::create($input);

        return redirect()->route('notice.index')
                        ->with('success','Notice created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        return Inertia::render('Notices/Show',['notice'=>$notice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {

        return Inertia::render('Notices/Edit',['notice'=>$notice]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        $this->validate($request, [
            'title' => 'nullable',
            'description' => 'nullable',
            'position' => 'nullable',
            'color' => 'nullable'
        ]);

        $input = $request->all();

        $notice->update($input);

        return redirect()->route('notice.index')
                        ->with('success','Notice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('notice.index')
                        ->with('success','Notice deleted successfully');
    }
}

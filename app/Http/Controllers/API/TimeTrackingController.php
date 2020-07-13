<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\TimeTracking;
use App\Client;

class TimeTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //dd($request->all());

        $timeTracking = TimeTracking::create([
            'start_time' => $request['start_time'],
            'end_time' => $request['end_time'],
            'total_time_spent' => $request['total_time_spent'],
            'notes' => $request['notes'],
            'project_id' => $request['project_id'],
        ]);

        return ['success' => true];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkTimeStatus($id) {

        $timeTracking = TimeTracking::findOrFail($id);

        return ['success' => true, 'timeTracking' => $timeTracking];

    }

    public function updateTimeStatus(Request $request) {

       

        $timeTracking = TimeTracking::findOrFail($request['id']);

        $timeTracking->update([
            'start_time' => $request['start_time'],
            'end_time' => $request['end_time'],
            'total_time_spent' => $request['total_time_spent'],
            "is_time_started" => $request['is_time_started'],
            'notes' => $request['notes'],
            'project_id' => $request['project_id'],
        ]);



        return ['success' => true];
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\TimeTracking;
use App\Client;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = Project::get();
        return ['success' => true, 'projects' => $projects];
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
       // dd($request->all());
        $project = Project::create([
            'project_name' => $request['project_name'],
            'project_description' => $request['project_description'],
            'label' => $request['label'],
            'due_date' => $request['due_date'],
            'due_time' => $request['due_time'],
            'client_id' => $request['client_id']

        ]);

        $timeTracking = TimeTracking::create([
            'project_id' => $project->id,
  
            'is_time_started' => 0,
          
        ]);

        return ['success' => 'true'];
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
        $project = Project::findOrFail($id);
        $project->update([
            'project_name' => $request['project_name'],
            'project_description' => $request['project_description'],
            'label' => $request['label'],
            'due_date' => $request['due_date'],
            'due_time' => $request['due_time'],
            'client_id' => $request['client_id']
        ]);

        return ['success' => true];
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
        $project = Project::findOrFail($id);
        $project->delete();

        return ['success' => true];
    }

    public function getClientProjects($id) {

        $client = Client::find($id);

        $clientProjects = Project::where('client_id', '=', $id)->get();


        foreach($clientProjects as $cp) {
            $ptt = TimeTracking::where('project_id', '=', $cp->id)->get();
            
            if(count($ptt) > 0) {
                $cp->projectTimeTracking =  $ptt[0];
            }
        }


        return ['success' => 'true', 'clientProjects' => ['client'=> $client,
         'projects' => $clientProjects] 
        ];
    }

    public function moveProjectToClient(Request $request) {
        $project = Project::create([
            'project_name' => $request['project_name'],
            'project_description' => $request['project_description'],
            'label' => $request['label'],
            'due_date' => $request['due_date'],
            'due_time' => $request['due_time'],
            'client_id' => $request['id']

        ]);

        return ['success' => 'true'];
    }
}

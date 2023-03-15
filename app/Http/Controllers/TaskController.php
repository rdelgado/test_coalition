<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::orderBy('priority', 'asc')->get();
        $projects = [
            [
                'label' => 'Project 1',
                'value' => 'Project 1',
            ],
            [
                'label' => 'Project 2',
                'value' => 'Project 2',
            ],
            [
                'label' => 'Project 3',
                'value' => 'Project 3',
            ],
            [
                'label' => 'Project 4',
                'value' => 'Project 4',
            ]
        ];

        $project = $request->project;
        if($project != "" && $project != "ALL"){

             $tasks = Task::where('project', 'like', '%'.$project.'%')
            ->orderBy('id', 'desc')->get();

            return view('index', compact('tasks'),  compact('projects'))
            ->with('task', $tasks);
        }

        return view('index', compact('tasks'),  compact('projects'));
    }




    public function updateOrder(Request $request)
    {
        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));
            
            foreach($arr as $sortOrder => $id){
                $tasks = Task::find($id);
                $tasks->priority = $sortOrder+1;
                $tasks->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = [
            [
                'label' => 'Project 1',
                'value' => 'Project 1',
            ],
            [
                'label' => 'Project 2',
                'value' => 'Project 2',
            ],
            [
                'label' => 'Project 3',
                'value' => 'Project 3',
            ],
            [
                'label' => 'Project 4',
                'value' => 'Project 4',
            ]
        ];
        return view('create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'priority' => 'required'
        ]);

        $task = new Task();
        $task->name = $request->name;
        $task->priority = $request->priority;
        $task->project = $request->project;
        $task->save();
        return redirect()->route('index');
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
        $task = Task::findOrFail($id);
        $projects = [
            [
                'label' => 'Project 1',
                'value' => 'Project 1',
            ],
            [
                'label' => 'Project 2',
                'value' => 'Project 2',
            ],
            [
                'label' => 'Project 3',
                'value' => 'Project 3',
            ],
            [
                'label' => 'Project 4',
                'value' => 'Project 4',
            ]
        ];
        return view('edit', compact('projects', 'task'));
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
        $task = Task::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'priority' => 'required'
        ]);

        $task->name = $request->name;
        $task->priority = $request->priority;
        $task->project = $request->project;
        $task->save();
        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('index');
    }
}

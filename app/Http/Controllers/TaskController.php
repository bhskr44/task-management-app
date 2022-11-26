<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

class TaskController extends Controller
{
    //
    
    public function addTask(Request $request)
    {
        $allTask = Tasks::select()->where('projectName', $request->projectName)->get();
        $allTasks = array();
        foreach($allTask as $task){
            $renewPriority = $task->priority;
            Tasks::where('id', $task->id)->update([
                'priority' => $task->priority + 1
            ]);
            // array_push( $allTasks,(['taskId'=>$task->id, 'priority'=>$renewPriority]));

        }
        // $allTask = Tasks::select()->where('projectName', $request->projectName)->get();

        // return $allTask;
        $task = new Tasks();
        $task->projectName = $request->projectName;
        $task->taskName = $request->taskName;
        $task->priority = 1;
        $task->save();
        return redirect()->back()->with('success', 'Task added successfully');   
    }


    public function home()
    {
        $allTask = Tasks::select()->where('projectName', 1)->orderBy('priority', 'asc')->get();
        return $allTask;
        return view('welcome', [
            'title' => 'Task Management App',
            'allTask' => $allTask,
            'projectName' => 1
            ]);
    }

    public function getTask($taskId)
    {
        $allTask = Tasks::select()->where('projectName', $taskId)->orderBy('priority', 'asc')->get();
        return view('welcome', [
            'title' => 'Task Management App',
            'allTask' => $allTask,
            'projectName' => $taskId
            ]);
        return $task;
    }

    public function deletetask(Request $request)
    {
        $task = Tasks::find($request->taskId);
        $projectId = $task->projectName;
        $task->delete();
        $allTask = Tasks::select()->where('projectName', $projectId)->orderBy('priority', 'asc')->get();
        // return $allTask;
        return redirect()->back()->with('success', 'Task added successfully');   

    }

    public function editTask(Request $request)
    {
        $task = Tasks::find($request->taskId);
        $task->taskName = $request->taskName;
        $task->save();
        $allTask = Tasks::select()->where('projectName', $request->projectId)->orderBy('priority', 'asc')->get();
        // return $allTask;
        return view('welcome', [
            'title' => 'Task Management App',
            'allTask' => $allTask,
            'taskId' => $request->projectId
            ]);
    }

    public function syncTask(Request $request){
        $draggingFrom = $request->draggingFrom;
        $draggingTo = $request->draggingTo;
        $projectName = $request->projectName;
        $dragFromId = Tasks::select('id')->where('projectName', $projectName)->where('priority', $draggingFrom)->first();
        $dragToId = Tasks::select('id')->where('projectName', $projectName)->where('priority', $draggingTo)->first();

        $dragFromTask = Tasks::find($dragFromId->id);
        $dragToTask = Tasks::find($dragToId->id);



        if($draggingFrom < $draggingTo){
            $allTask = Tasks::select()->where('projectName', $projectName)->whereBetween('priority', [$draggingFrom, $draggingTo])->get();
            foreach($allTask as $task){
                $renewPriority = $task->priority;
                if($renewPriority > 0){
                    Tasks::where('id', $task->id)->update([
                        'priority' => $task->priority - 1
                    ]);
                }
            }
        }else{
            $allTask = Tasks::select()->where('projectName', $projectName)->whereBetween('priority', [$draggingTo, $draggingFrom])->get();
            foreach($allTask as $task){
                $renewPriority = $task->priority;
                if($renewPriority > 0){
                    Tasks::where('id', $task->id)->update([
                        'priority' => $task->priority + 1
                    ]);
                }
            }
        }

        Tasks::where('id', $dragFromId->id)->update([
            'priority' => $dragToTask->priority
        ]);



       
        
        return json_encode(['status' => 'success', 'message' => 'Task synced successfully']);
      
    }
}


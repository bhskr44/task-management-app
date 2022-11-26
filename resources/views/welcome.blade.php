<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <h1>Task Management App</h1>

    <div class="form-ele">
        <form id="tasks-form" action="/add-task" method="post">
            @csrf
            <select name="projectName" id="projectName">
                <option value="1"  @if($projectName == 1 ) selected @endif >Project 1</option>
                <option value="2" @if($projectName == 2 ) selected @endif >Project 2</option>
                <option value="3" @if($projectName == 3 ) selected @endif >Project 3</option>
            </select>

            <input type="text" name="taskName" id="taskName" placeholder="Task Name">
            <button class="btn" type="submit">Submit</button>
        </form>
    </div>
    <div id="tasks" class="tasks"> 
        <h2>#My Tasks for Project <span id="selectedProject"></span></h2>
        <ul class="singleTask">
            @foreach($allTask as $task)
                <li class="dragable" id="{{$task->priority}}" draggable="true"><div class="task"><h2>{{$task->taskName}}</h2><div class="icons"><form class="btn-forms" method="post" action="/edit-task"> @csrf <input type="hidden" name="taskId" value="{{$task->id}}"><button class="form-button" type="submit"><i class="fa-solid fa-pen-to-square fa-2x"></i></button></form><form  class="btn-forms" method="post" action="/delete-task"> @csrf <input type="hidden" name="taskId" value="{{$task->id}}"><button class="form-button" type="submit"><i class="fa-solid fa-trash fa-2x"></i></button></form></div></div> </li>
            @endforeach
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
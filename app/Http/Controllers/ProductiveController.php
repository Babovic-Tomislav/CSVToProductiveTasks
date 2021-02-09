<?php

namespace App\Http\Controllers;


use App\CSVParser\CsvParser;
use App\RequestForms\CSVRequest;
use App\RequestForms\ProductiveApiAuthTokenRequest;
use App\Services\Productive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class ProductiveController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function showProjectList(ProductiveApiAuthTokenRequest $request)
    {
        Cookie::queue('authToken', $request->authToken, 60);

        $projects = Productive::getProjectList($request->authToken);

        return view('projectPick')->with('projects', $projects);
    }

    public function taskLists(Request $request)
    {
        Cookie::queue('project_id', $request->project_id);

        $taskLists = Productive::getTaskLists($request->cookie('authToken'),
            $request->project_id);

        return response()->json([
            'taskLists' => $taskLists
        ]);

        return view('taskListPick')->with('taskLists', $taskLists);
    }

    public function uploadTasks(CSVRequest $request)
    {
        $file = $request->file('csv_file');


        $parser = new CsvParser($file->getRealPath());

        if (!$parser->validateCsv($file)) {
            return back()->withErrors(['badCsv' => 'Your .CSV headers do not meet the requirements.']);
        }

        Cookie::queue('task_list_id', $request->taskList);

        $tasks = $parser->parse();
        dd($tasks);
        foreach ($tasks as $task) {
            Productive::createTaskOnProductive($task,
                $request->cookie('authToken'),
                $request->cookie('project_id'),
                $request->cookie('task_list_id'));
        }

        return redirect('/');
    }
}

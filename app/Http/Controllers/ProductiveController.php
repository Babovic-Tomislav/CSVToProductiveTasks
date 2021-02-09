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

    public function taskList(Request $request)
    {
        $taskLists = Productive::getTaskLists($request->cookie('authToken'));

        return view('taskListPick')->with('taskLists', $taskLists);
    }


}

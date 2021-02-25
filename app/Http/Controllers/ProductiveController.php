<?php

namespace App\Http\Controllers;


use App\CSVParser\CsvParserInterface;
use App\RequestForms\CSVRequest;
use App\RequestForms\ProductiveApiAuthTokenRequest;
use App\Services\Productive;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class ProductiveController extends Controller
{
    private $productive;

    public function __construct(Productive $productive)
    {
        $this->productive = $productive;
    }

    public function index()
    {
        return view('index');
    }

    public function projectList(ProductiveApiAuthTokenRequest $request)
    {
        $projects
            = $this->productive->getProjectList($request->get('authToken'));

        if ($projects === false) {
            return new JsonResponse('Something went wrong getting the projects',
                Response::HTTP_BAD_REQUEST
            );
        }

        if (empty($projects)) {
            return new JsonResponse('No projects available',
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json([
            'projects' => $projects
        ]);
    }

    public function taskLists(ProductiveApiAuthTokenRequest $request)
    {
        $taskLists = $this->productive->getTaskLists(
            $request->get('authToken'),
            $request->route('projectId')
        );

        if ($taskLists === false) {
            return new JsonResponse('Something went wrong getting the task lists',
                Response::HTTP_BAD_REQUEST
            );
        }

        if (empty($taskLists)) {
            return new JsonResponse("No task list available",
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json([
            'taskLists' => $taskLists
        ]);
    }

    public function uploadTasks(
        CSVRequest $request,
        CsvParserInterface $csvParser
    ) {
        $file = $request->file('csvFile');

        if (!$csvParser->validateCsv($file)) {
            return new JsonResponse('Wrong format of csv file',
                Response::HTTP_BAD_REQUEST);
        }
        $tasks = $csvParser->parse($file);

        foreach ($tasks as $task) {
            $response = $this->productive->createTaskOnProductive(
                $task,
                $request->get('authToken'),
                $request->get('projectId'),
                $request->get('taskListId')
            );

            if (!$response) {
                return new JsonResponse('Something went wrong with uploading tasks.',
                    Response::HTTP_BAD_REQUEST);
            }
        }

        return new JsonResponse('Successfully uploaded tasks on productive',
            Response::HTTP_OK);
    }
}

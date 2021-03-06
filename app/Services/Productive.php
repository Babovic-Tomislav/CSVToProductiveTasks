<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Throwable;


class Productive
{
    private $url = 'https://api.productive.io//api/v2/';

    public function getProjectList(string $authToken)
    {
        try {
            $response = Http::withHeaders($this->makeHeader($authToken))
                ->get($this->url . 'projects', ['page[size]' => 10]);

            if ($response->status() != 200) {
                return false;
            }

            $projects = [];
            $projects = $this->ResponseBuilder($response['data'], $projects);

            while (array_key_exists('next',$response['links'])){
                $response = Http::withHeaders($this->makeHeader($authToken))
                    ->get(
                        $response['links']['next']
                    );

                if ($response->status() != 200) {
                    return false;
                }

                $projects = $this->ResponseBuilder($response['data'], $projects);
            }

            return $projects;
        } catch (throwable $e) {
            report($e);
        }
    }

    private function makeHeader(string $authToken)
    {
        return [
            'Content-Type'      => 'application/vnd.api+json',
            'X-Organization-Id' => env('ORGANISATION_ID'),
            'X-Auth-Token'      => $authToken
        ];
    }

    public function getTaskLists(string $authToken, string $projectId)
    {
        try {
            $response = Http::withHeaders($this->makeHeader($authToken))
                ->get($this->url . 'task_lists',
                      [
                          'filter[project_id]' => $projectId,
                          'page[size]'         => 10
                      ]);

            if ($response->status() != 200) {
                return false;
            }

            $taskLists = [];
            $taskLists = $this->ResponseBuilder($response['data'], $taskLists);

            while (array_key_exists('next',$response['links'])){
                $response = Http::withHeaders($this->makeHeader($authToken))
                    ->get(
                        $response['links']['next']
                    );

                if ($response->status() != 200) {
                    return false;
                }

                $taskLists = $this->ResponseBuilder($response['data'], $taskLists);
            }
            return $taskLists;
        } catch (throwable $e) {
            report($e);
        }
    }

    public function createTaskOnProductive(
        array $task,
        string $authToken,
        string $projectId,
        string $taskListId
    ) {
        try {
            $response = Http::withHeaders($this->makeHeader($authToken))
                ->withBody(
                    $this->prepareBody(
                        $task,
                        $projectId,
                        $taskListId
                    ),
                    'application/json'
                )
                ->post($this->url . 'tasks');

            if ($response->status() != Response::HTTP_CREATED) {
                return false;
            }

            return $response['data']['id'];
        } catch (throwable $e) {
            report($e);
        }
    }

    private function prepareBody(
        array $task,
        string $projectId,
        string $taskListId
    ) {
        $body = [
            "data" => [
                "type"          => "tasks",
                "attributes"    => [
                    "title"            => $task['title'],
                    "initial_estimate" => $task['time'],
                    "remaining_time"   => $task['time'],
                    "description"      => $task['description']
                ],
                "relationships" => [
                    "project"   => [
                        "data" => [
                            "type" => "projects",
                            "id"   => $projectId
                        ]
                    ],
                    "task_list" => [
                        "data" => [
                            "type" => "task_lists",
                            "id"   => $taskListId
                        ]
                    ]
                ]
            ]
        ];

        return json_encode($body);
    }

    private function ResponseBuilder(array $data, array $returnData = null)
    {
        foreach ($data as $d) {
            $returnData[] = $d;
        }
        
        return $returnData;
    }


}
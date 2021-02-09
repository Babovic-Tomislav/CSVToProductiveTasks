<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;

class Productive
{
    public static function getProjectList(string $authToken)
    {
        return Http::withHeaders([
            'Content-Type'      => 'application/vnd.api+json',
            'X-Organization-Id' => env('ORGANISATION_ID'),
            'X-Auth-Token'      => $authToken
        ])
                   ->get('https://api.productive.io//api/v2/projects')['data'];
    }

    public static function getTaskLists(string $authToken)
    {
        return Http::withHeaders([
            'Content-Type'      => 'application/vnd.api+json',
            'X-Organization-Id' => env('ORGANISATION_ID'),
            'X-Auth-Token'      => $authToken
        ])
                   ->get('https://api.productive.io//api/v2/task_lists')['data'];
    }

    public static function createTaskOnProductive(
        array $task,
        string $authToken,
        string $project_id,
        string $taskList_id
    ) {
        Http::withHeaders([
            'Content-Type'      => 'application/vnd.api+json',
            'X-Organization-Id' => env('ORGANISATION_ID'),
            'X-Auth-Token'      => $authToken
        ])
            ->withBody(self::prepareBody($task, $project_id, $taskList_id),
                'application/json')
            ->post('https://api.productive.io//api/v2/tasks');
    }

    private static function prepareBody(
        array $task,
        string $project_id,
        string $taskList_id
    ) {
        return '{
                  "data": {
                            "type": "tasks",
                        "attributes": {
                                "title": "' . $task['title'] . '",
                        "initial_estimate": ' . $task['time'] . ',
                        "remaining_time": ' . $task['time'] . ',
                        "description":"' . $task['description'] . '"
                        },
                        "relationships": {
                                "project": {
                                    "data": {
                                        "type": "projects",
                            "id": "' . $project_id . '"
                            }
                        },
                        "task_list": {
                                    "data": {
                                        "type": "task_lists",
                            "id": "' . $taskList_id . '"
                            }
                        }
                        }
                  }
                }';
    }
}
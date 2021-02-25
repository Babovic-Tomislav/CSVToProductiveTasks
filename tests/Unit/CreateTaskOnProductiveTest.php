<?php

namespace Tests\Unit;

use App\Services\Productive;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CreateTaskOnProductiveTest extends TestCase
{
    //stavit u env
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateTaskOnProductive()
    {
        $productive = new Productive();
        $task       = [
            'title'       => 'title',
            'description' => 'description',
            'time'        => 1000
        ];

        $newTaskId = $productive->createTaskOnProductive(
            $task,
            env('AUTH_TOKEN'),
            env('PROJECT_ID'),
            env('TASK_LIST_ID')
        );

        $response = Http::withHeaders($this->makeHeader())
            ->get('https://api.productive.io//api/v2/tasks/' . $newTaskId);

        //dodati provjere title, opis, time
        $this->assertEquals($task['title'],
            $response['data']['attributes']['title']);
        $this->assertEquals($task['description'],
            $response['data']['attributes']['description']);
        $this->assertEquals($task['time'],
            $response['data']['attributes']['initial_estimate']);

        Http::withHeaders($this->makeHeader())
            ->delete('https://api.productive.io//api/v2/tasks/' . $newTaskId);
    }

    private function makeHeader()
    {
        return [
            'Content-Type'      => 'application/vnd.api+json',
            'X-Organization-Id' => env('ORGANISATION_ID'),
            'X-Auth-Token'      => env('AUTH_TOKEN')
        ];
    }
}

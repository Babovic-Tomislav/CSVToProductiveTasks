<?php

namespace Tests\Feature;

use App\Services\Productive;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CreateTaskOnProductiveTest extends TestCase
{
    private string $authToken = '0aaf5bbc-7f38-443a-bc37-2a517b50cb87';
    private string $projectId = '112834';
    private string $taskListId = '296428';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $productive = new Productive();
        $task = [
            'title' => 'unit test',
            'description' => 'unit test',
            'time' => 1000
        ];

        $newTaskId = $productive->createTaskOnProductive(
            $task,
            $this->authToken,
            $this->projectId,
            $this->taskListId
        );

        $response = Http::withHeaders($this->makeHeader($this->authToken))
            ->get('https://api.productive.io//api/v2/tasks/'.$newTaskId);

        $this->assertEquals($newTaskId, $response['data']['id']);

        Http::withHeaders($this->makeHeader($this->authToken))
            ->delete('https://api.productive.io//api/v2/tasks/'.$newTaskId);
    }

    private function makeHeader(string $authToken)
    {
        return [
            'Content-Type'      => 'application/vnd.api+json',
            'X-Organization-Id' => env('ORGANISATION_ID'),
            'X-Auth-Token'      => $this->authToken
        ];
    }
}

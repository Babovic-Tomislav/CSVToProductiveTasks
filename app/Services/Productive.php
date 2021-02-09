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
}
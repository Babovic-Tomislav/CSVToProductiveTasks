<?php

namespace App\Http\Controllers;

use App\RequestForms\ProductiveApiAuthTokenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductiveController extends Controller
{

    public function index()
    {
        return view('index');
    }

    public function connect(ProductiveApiAuthTokenRequest $request)
    {
        $response = Http::withHeaders(
                ['Content-Type'=>'application/vnd.api+json',
                'X-Organization-Id'=> '4085',
                'X-Auth-Token'=> $request->authToken])->get('https://api.productive.io//api/v2/projects');
        //dd($response['data']);
        return view('projectPick')->with('projects', $response['data']);
    }


}

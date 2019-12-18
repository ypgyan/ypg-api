<?php

namespace Src\Heimdall\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Index de persons
     */
    public function index()
    {
        $response = [
            "status" => "success",
            "message" => "Welcome to YPG api"
        ];
        return response()->json($response);
    }
}

<?php

namespace Src\Persons\Controllers;

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
            "message" => "Bem vindo a API geradora de pessoas do YPG"
        ];
        return response()->json($response);
    }
}

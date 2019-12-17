<?php

namespace Src\Heimdall\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Respect\Validation\Validator as v;
use Src\Heimdall\Services\SignupService;

class SignupController extends Controller
{

    /**
     * Interface do sevico de signup
     * 
     * @var SignupService
     */
    private $signupService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SignupService $signupService)
    {
        $this->signupService = $signupService;
    }

    /**
     * Index de persons
     */
    public function index()
    {
        $response = [
            "title" => "Seja bem vindo a pagina de registro",
            "message" => "To receive a token to access the API you need to send a post to register/signup with (name,last_name,cpf,cellphone,email*)"
        ];
        return response()->json($response);
    }

    /**
     * Cria o usuário no sistema
     * 
     * @param Request $request
     * @return Json
     */
    public function signup(Request $request)
    {
        $data = $request->all();

        if(!empty($data["email"])) {
            if (!v::email()->validate($data["email"])) {
                $response = [
                    "error" => "Email inválido"
                ];
                return response()->json($response);
            }
        }

        if (!v::cpf()->validate($data["cpf"])) {
            $response = [
                "error" => "CPF inválido"
            ];
            return response()->json($response);
        }
        
        if ($this->signupService->verificaCPF($data["cpf"])) {
            $response = [
                "message" => "You already has a token"
            ];

            return response()->json($response);
        }else{
            try {
                DB::beginTransaction();
                if($this->signupService->createUser($data)) {
                    $token = $this->signupService->createToken($data["cpf"]);
                }
    
                DB::commit();
    
                $response = [
                    "status" => "success",
                    "message" => "Signup success",
                    "api_token" => $token
                ];
    
                return response()->json($response);
            } catch (\Exception $e) {
                DB::rollback();
                Log::critical('Signup Error: ' . $e->getMessage());
                return response()->json([
                    "Error" => "Somenthing went wrong try again."
                ]);
            }
        }
    }
}

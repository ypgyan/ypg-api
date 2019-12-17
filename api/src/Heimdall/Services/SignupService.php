<?php

namespace Src\Heimdall\Services;

use App\User;

class SignupService
{
    /**
     * Cria o usuário
     *
     * @param Array $var
     * @return bool
     */
    public function createUser(Array $userData)
    {
        try {
            $user = new User();
            
            $user->name = $userData["name"];
            $user->last_name = $userData["last_name"];
            $user->cpf = $userData["cpf"];
            $user->cellphone = $userData["cellphone"];
            $user->email = $userData["email"];
            
            $user->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Cria o token de acesso a API para o usuário
     * 
     * @param string $cpf
     * @return string
     */
    public function createToken(string $cpf)
    {
        $token = $this->bcrypt($cpf);
        $user = User::where('cpf',$cpf)->first();
        $user->api_token = $token;
        $user->save();

        return $token;
    }

    /**
     * Cria uma hash usando bcrypt
     *
     * @param string $value
     * @param array $options
     * @return void
     */
    private function bcrypt($value, $options = [])
    {
        return app('hash')->make($value, $options);
    }

    /**
     * Verifica se o CPF é valido
     * 
     * @param string $cpf
     * @return bool
     */
    public function verificaCPF(string $cpf)
    {
        $user = User::where('cpf', $cpf)->first();

        if (!empty($user) || !empty($user->api_token)) {
            return true;
        }else{
            return false;
        }
    }
}

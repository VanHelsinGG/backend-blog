<?php

namespace Api\Php\Controllers;

use Api\Php\Models\User;
use Api\Php\Handler\Request;
use InvalidArgumentException;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->data();

        if (!isset($data['email']) || !isset($data['name'])) {
            $this->exception(new InvalidArgumentException("'Email' and 'Name' is required"), 400);
        }

        $user = User::create($data['name'], $data['email']);

        return $this->json(['user' => $user]);
    }

    public function find()
    {
        return $this->json(['users' =>
        [
            0 => [
                'email' => 'teste@gmail.com',
                'name' => 'victor',
            ],
            1 => [
                'email' => 'teste2@gmail.com',
                'name' => 'victor2',
            ],
        ]]);
    }
}

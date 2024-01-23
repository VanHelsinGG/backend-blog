<?php

namespace Api\Php\Models;

class User
{
    protected $email;
    protected $name;

    private function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
    }

    public static function create($email, $name)
    {
        $user = new User($email, $name);
        return $user->getAttributes();
    }

    public function getAttributes()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}

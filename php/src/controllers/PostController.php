<?php

namespace Api\Php\Controllers;

use Api\Php\Handler\Request;
use InvalidArgumentException;
use Api\Php\Models\Post;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->data();

        if (!isset($data['userID']) || !isset($data['content'])) {
            $this->exception(new InvalidArgumentException("'userID' and 'content' is required"), 400);
        }

        $post = Post::create($data['userID'], $data['content']);

        return $this->json(['post' => $post]);
    }

    public function find()
    {
        return $this->json(['posts' =>
        [
            0 => [
                'userID' => '0',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ultrices vitae est eu condimentum. Vivamus faucibus lorem vitae augue vestibulum molestie. Aenean rhoncus, ante ac imperdiet commodo, magna felis lacinia nisi, eu tempor enim justo non nisi. ',
            ],
            1 => [
                'userID' => '1',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ultrices vitae est eu condimentum. Vivamus faucibus lorem vitae augue vestibulum molestie. Aenean rhoncus, ante ac imperdiet commodo, magna felis lacinia nisi, eu tempor enim justo non nisi. ',
            ],
        ]]);
    }
}
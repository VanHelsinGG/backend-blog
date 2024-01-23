<?php

namespace Api\Php\Models;

class Post
{
    protected $userID;
    protected $content;

    private function __construct($userID, $content)
    {
        $this->userID = $userID;
        $this->content = $content;
    }

    public static function create($userID, $content)
    {
        $post = new Post($userID, $content);
        return $post->getAttributes();
    }

    public function getAttributes()
    {
        return [
            'userID' => $this->userID,
            'content' => $this->content,
        ];
    }
}

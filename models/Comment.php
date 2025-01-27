<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

require_once "Post.php";

class Comment

{

    private ?int $id = null;
    public function __construct(
        private string $content,
        private int $user_id,
        private int $post_id,
        private Post $post
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getPostId(): int
    {
        return $this->post_id;
    }

    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }


    public function getPost(): Post
    {
        return $this->post;
    }


    public function setPost(Post $post): void
    {
        $this->post = $post;
    }
}

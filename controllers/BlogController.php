<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */



class BlogController extends AbstractController
{
    public function home(): void
    {


        $postManager = new PostManager();
        $latestPosts = $postManager->findLatest();
        $this->render("home", ['latestPosts' => $latestPosts]);
    }

    public function category(string $categoryId): void
    {

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }
        $categoryManager = new CategoryManager();
        $latestPosts = $categoryManager->findOne($id);
        $this->render("category", []);

        // sinon
        $this->redirect("index.php");
    }

    public function post(string $postId): void
    {
        // si le post existe
        if (isset($_GET["post_id"])) {
            $id = $_GET["post_id"];
        }

        $commentManager = new CommentManager();
        $comments = $commentManager->findByPost($id);

        $postManager = new PostManager();
        $post = $postManager->findOne($id);
        if ($post) {

            $this->render('post', [
                'post' => $post,
                'comments' => $comments
            ]);
        } else {

            $this->redirect('index.php');
        }
    }

    public function checkComment(): void
    {
        $this->redirect("index.php?route=post&post_id={$_POST["post_id"]}");
    }
}

// $blogController = new BlogController();
// $blogController->home();
// var_dump($blogController);

<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */



class PostManager extends AbstractManager
{
    public function findLatest(): array
    {


        //Requête avec jointure pour récupérer l'id de la catégorie correpondant au post
        $query = 'SELECT posts.*, author AS author_id, categories.id AS category_id
          FROM posts
          JOIN posts_categories ON posts.id = posts_categories.post_id
          JOIN categories ON posts_categories.category_id = categories.id
          ORDER BY posts.created_at DESC
          LIMIT 4';

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];

        // On instance les managers respectifs de User et Category afin de pouvoir utiliser leurs méthodes
        $userManager = new UserManager($this->db);
        $categoryManager = new CategoryManager($this->db);

        foreach ($results as $result) {
            //on récupère les informations du user et de la catégorie correpondant au post en passant l'id récupéré de la BDD en paramètres
            $user = $userManager->findOne($result['author_id']);
            $category = $categoryManager->findOne($result['category_id']);

            // On créer un nouveau post avec toutes les infos récupérées
            $post = new Post(
                $result['title'],
                $result['excerpt'],
                $result['content'],
                $user,
                new DateTime($result['created_at']),
                $category
            );
            $post->setId($result['id']);

            $posts[] = $post;
        }

        return $posts;
    }




    //  findOne(int $id) qui retourne le post qui a l’id passé en paramètre, null si il n’existe pas
    public function findOne(int $id): ?Post
    {
        $query = 'SELECT posts.*, author AS author_id, categories.id AS category_id
          FROM posts
          JOIN posts_categories ON posts.id = posts_categories.post_id
          JOIN categories ON posts_categories.category_id = categories.id
          WHERE posts.id = :id
          LIMIT 1';


        $stmt = $this->db->prepare($query);
        $parameters = ['id' => $id];
        $stmt->execute($parameters);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }


        $userManager = new UserManager($this->db);
        $categoryManager = new CategoryManager($this->db);

        $user = $userManager->findOne($result['author_id']);
        $category = $categoryManager->findOne($result['category_id']);

        $post = new Post(
            $result['title'],
            $result['excerpt'],
            $result['content'],
            $user,
            new DateTime($result['created_at']),
            $category
        );
        $post->setId($result['id']);

        return $post;
    }


    //  findByCategory(int $categoryId) qui retourne les posts ayant la catégorie dont l’id est passé en paramètre

    public function findByCategory(int $categoryId): array
    {

        $query = 'SELECT posts.*, author AS author_id, categories.id AS category_id
                FROM posts
                JOIN posts_categories ON posts.id = posts_categories.post_id
                JOIN categories ON posts_categories.category_id = categories.id
                WHERE categories.id = :categoryId
                ORDER BY posts.created_at DESC';

        $stmt = $this->db->prepare($query);
        $stmt->execute(['categoryId' => $categoryId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $posts = [];



        $userManager = new UserManager($this->db);
        $categoryManager = new CategoryManager($this->db);

        foreach ($results as $result) {

            $user = $userManager->findOne($result['author_id']);
            $category = $categoryManager->findOne($result['category_id']);




            $post = new Post($result['title'], $result['excerpt'], $result['content'], $user, new DateTime($result['created_at']), $category);
            $post->setId($result['id']);


            $posts[] = $post;
        }

        return $posts;
    }
}

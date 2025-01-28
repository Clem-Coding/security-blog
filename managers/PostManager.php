<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */





// class PostManager extends AbstractManager
// {

//     //  findLatest() qui retourne les 4 derniers posts
//     public function findLatest(): array
//     {
//         $query = 'SELECT 
//                 posts.id, 
//                 posts.title, 
//                 posts.excerpt, 
//                 posts.created_at, 
//                 posts.author, 
//                 posts.content,
//                 users.username, 
//                 categories.id AS category_id, 
//                 categories.title AS category_title
//                 FROM posts
//                 JOIN users ON posts.author = users.id
//                 JOIN posts_categories ON posts.id = posts_categories.post_id
//                 JOIN categories ON posts_categories.category_id = categories.id
//                 ORDER BY posts.created_at DESC
//                 LIMIT 4';

//         $stmt = $this->db->prepare($query);
//         $stmt->execute();
//         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         // MON TABLEAU DE $results A PRIORI retourné (avec exemples fictifs)
//         // [
//         //     'id' => 10,                     
//         //     'title' => 'Titre du post',  
//         //     'excerpt' => 'blablabla'    
//         //     'created_at' => '2023-01-15',  
//         //     'author' => 1,                 
//         //     'username' => 'Auteur1',       
//         //     'category_id' => 2,            
//         //     'category_title' => 'Catégorie 1' 
//         // ]

//         $posts = [];
//         foreach ($results as $result) {

//             // On instancie un nouvel utilisateur avec : username, 
//             // on a besoin que du username à priori pour le post, on peut instancier qu'un seul attribut du fait qu'on a intialisé
//             //les autres attributs dans le constructeur de User avec une string vide
//             $user = new User($result['username']);

//             // Attribuer un ID unique à l'objet User (qui correspond à l'auteur du post récupéré).
//             $user->setId($result['author']);

//             //idem pour category, on a besoin que du titre
//             $category = new Category($result['category_title']);
//             $category->setId($result['category_id']);

//             //créer un objet post qui représente le post complet
//             $post = new Post($result['title'], $result['excerpt'], $result['content'], $user, new DateTime($result['created_at']), $category);
//             $post->setId($result['id']);

//             //on ajoute chaque post instancié dans le tableau $posts qui sera retourné
//             $posts[] = $post;
//         }
//         return $posts;
//     }


class PostManager extends AbstractManager
{
    public function findLatest(): array
    {

        $query = 'SELECT 
            posts.*, 
            categories.id AS category_id
          FROM posts
          JOIN posts_categories ON posts.id = posts_categories.post_id
          JOIN categories ON posts_categories.category_id = categories.id
          ORDER BY posts.created_at DESC
          LIMIT 4';

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];


        $userManager = new UserManager($this->db);
        $categoryManager = new CategoryManager($this->db);

        foreach ($results as $result) {

            $user = $userManager->findOne($result['author']);
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

            $posts[] = $post;
        }

        return $posts;
    }




    //  findOne(int $id) qui retourne le post qui a l’id passé en paramètre, null si il n’existe pas
    public function findOne(int $id): ?Post
    {
        $query = 'SELECT 
                posts.id, 
                posts.title, 
                posts.excerpt, 
                posts.content, 
                posts.created_at, 
                posts.author, 
                users.username, 
                categories.id AS category_id, 
                categories.title AS category_title
              FROM posts
              JOIN users ON posts.author = users.id
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


        $user = new User($result['username']);
        $user->setId($result['author']);

        $category = new Category($result['category_title']);
        $category->setId($result['category_id']);

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

        $query = 'SELECT 
                posts.id, 
                posts.title, 
                posts.excerpt, 
                posts.content, 
                posts.created_at, 
                posts.author, 
                users.username, 
                categories.id AS category_id, 
                categories.title AS category_title
              FROM posts
              JOIN users ON posts.author = users.id
              JOIN posts_categories ON posts.id = posts_categories.post_id
              JOIN categories ON posts_categories.category_id = categories.id
              WHERE categories.id = :categoryId
              ORDER BY posts.created_at DESC';

        $stmt = $this->db->prepare($query);
        $stmt->execute(['categoryId' => $categoryId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $posts = [];


        foreach ($results as $result) {

            $user = new User($result['username']);
            $user->setId($result['author']);

            $category = new Category($result['category_title']);
            $category->setId($result['category_id']);


            $post = new Post($result['title'], $result['excerpt'], $result['content'], $user, new DateTime($result['created_at']), $category);
            $post->setId($result['id']);


            $posts[] = $post;
        }

        return $posts;
    }
}
